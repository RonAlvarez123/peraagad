<?php

namespace App\Models;

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

    private int $codePrice = 500;
    private int $signUpBonus = 400;

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

    public function captchaCredit()
    {
        return $this->hasOne(CaptchaCredit::class, 'user_id', 'user_id');
    }

    public function getSignUpBonus()
    {
        $this->money += $this->signUpBonus;
        return $this->save();
    }

    public function addDirectInvite()
    {
        $this->direct += 1;
        $this->money += ($this->codePrice * .4);
        return $this->save();
    }

    public function addIndirectInvite()
    {
        $this->indirect += 1;
        $this->money += ($this->codePrice * .02);
        return $this->save();;
    }

    public function getMoneyFromCaptcha($rate = 0)
    {
        $this->money += $rate;
        return $this->save();
    }
}
