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
    private $dailyBonus = [
        'rate' => 5,
        'limit' => 5,
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function codes()
    {
        return $this->hasMany(Code::class, 'user_id', 'user_id');
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
}
