<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'phone_number',
        'city',
        'province',
        'account_code',
        'password',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'user_id', 'user_id');
    }

    public function codes()
    {
        return $this->hasMany(Code::class);
    }

    public function coderequests()
    {
        return $this->hasMany(CodeRequest::class, 'user_id', 'user_id');
    }

    public function captchaCredit()
    {
        return $this->hasOne(CaptchaCredit::class, 'user_id', 'user_id');
    }

    public function setUserId()
    {
        $this->user_id = $this->id;
        return $this->save();
    }
}
