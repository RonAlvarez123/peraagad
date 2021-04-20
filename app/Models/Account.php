<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'referrer_id',
        'role',
    ];

    private int $directBonus = 50;
    private int $indirectBonus = 5;
    private int $signUpBonus = 200;
    private $cashoutRemainder = 0;
    private $previousBalance = 0;
    private $dailyBonus = [
        'rate' => 5,
        'limit' => 5,
    ];
    private int $minCashout = 1000;
    private $cashoutDeductPercentage = [
        'fee' => .03,
        'tax' => .1,
    ];
    private $cashoutDeductions = [
        'fee' => 0,
        'tax' => 0,
    ];
    private $cashout = [
        'total' => 0,
        'deducted' => 0,
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function codes()
    {
        return $this->hasMany(Code::class, 'user_id', 'user_id');
    }

    public function hasCodes()
    {
        if ($this->totalCodes() > 0) {
            return true;
        }
        return false;
    }

    public function totalCodes()
    {
        $codes = $this->codes;
        return count($codes);
    }

    public function timesRequestedForCode()
    {
        return $this->hasMany(CodeRequest::class, 'user_id', 'user_id');
    }

    public function totalCodeRequests()
    {
        return $this->hasMany(CodeRequest::class, 'user_id', 'user_id')->sum('number_of_codes');
    }

    public function getReferredAccounts()
    {
        return $this->hasMany(Account::class, 'referrer_id', 'user_id');
    }

    public function getReferrerAccount()
    {
        return $this->belongsTo(Account::class, 'referrer_id', 'user_id');
    }

    public function receipt()
    {
        return $this->hasOne(Receipt::class, 'user_id', 'user_id');
    }

    public function userCaptcha()
    {
        return $this->hasOne(UserCaptcha::class, 'user_id', 'user_id');
    }

    public function colorGame()
    {
        return $this->hasOne(ColorGame::class, 'user_id', 'user_id');
    }

    public function cashoutRequest()
    {
        return $this->hasOne(CashoutRequest::class, 'user_id', 'user_id');
    }

    public function getSignUpBonus()
    {
        $this->money += $this->signUpBonus;
        return $this->save();
    }

    public function addDirectInvite()
    {
        $this->direct += 1;
        $this->money += $this->directBonus;
        return $this->save();
    }

    public function addIndirectInvite()
    {
        $this->indirect += 1;
        $this->money += $this->indirectBonus;
        return $this->save();;
    }

    public function getMoney($rate = 0)
    {
        $this->money += $rate;
        return $this->save();
    }

    public function isBonusClaimable()
    {
        if ($this->bonus_claimed_at != null && ($this->number_of_bonus_claimed >= $this->dailyBonus['limit'] || Carbon::parse($this->bonus_claimed_at)->addSeconds(15) >= now())) {
            return false;
        }
        return true;
    }

    public function getDailyBonus()
    {
        if ($this->isBonusClaimable()) {
            $this->number_of_bonus_claimed += 1;
            $this->bonus_claimed_at = now();
            $this->money += $this->dailyBonus['rate'];
            return $this->save();
        }
        return false;
    }

    public function canCashout()
    {
        if ($this->money >= $this->minCashout) {
            return true;
        }
        return false;
    }

    public function createCashoutRequest()
    {
        if ($this->canCashOut()) {
            $this->setPreviousBalance($this->money);
            $this->money = round($this->money - $this->setCashoutDeductions($this->money), 2);
            $this->money += round($this->cashoutRemainder * .01, 2);
            return $this->save();
        }
        return false;
    }

    public function setCashoutDeductions($value)
    {
        $validAmount = explode('.', $value);
        $this->cashoutDeductions['fee'] = $validAmount[0] * $this->cashoutDeductPercentage['fee'];
        $this->cashoutDeductions['tax'] = $validAmount[0] * $this->cashoutDeductPercentage['tax'];
        $result = explode('.', $validAmount[0] - ($this->cashoutDeductions['fee'] + $this->cashoutDeductions['tax']));
        $this->cashout['deducted'] = $result[0];
        $this->cashout['total'] = $validAmount[0];
        if (array_key_exists(1, $result)) {
            $this->cashoutRemainder = $result[1];
        }
        // $result[3] = 'total tax and fee : ' . $this->cashoutDeductions['fee'] + $this->cashoutDeductions['tax'];
        // return $result;
        return $this->cashout['total'];
    }

    public function getCashoutFee()
    {
        return $this->cashoutDeductions['fee'];
    }

    public function getCashoutTax()
    {
        return $this->cashoutDeductions['tax'];
    }

    public function getTotalCashout()
    {
        return $this->cashout['total'];
    }

    public function getDeductedCashout()
    {
        return $this->cashout['deducted'];
    }

    public function setPreviousBalance($value)
    {
        $this->previousBalance = $value;
    }

    public function getPreviousBalance()
    {
        return $this->previousBalance;
    }

    public function getBalance()
    {
        return $this->money;
    }
}
