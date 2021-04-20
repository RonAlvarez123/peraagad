<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;

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
        'created_at',
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

    public function setUserId()
    {
        $this->user_id = $this->id;
        return $this->save();
    }

    public function joinedAt()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function getValidTime()
    {
        return Carbon::parse($this->updated_at)->addDays(15);
    }

    public function canChangePassword()
    {
        if ($this->updated_at != null && $this->getValidTime() >= now()) {
            return false;
        }
        return true;
    }

    public function changePassword($value)
    {
        if ($this->canChangePassword()) {
            $this->password = Hash::make($value);
            $this->updated_at = now();
            return $this->save();
        }
        return false;
    }

    public function passwordChangedAt()
    {
        return Carbon::parse($this->updated_at)->diffForHumans();
    }
}
