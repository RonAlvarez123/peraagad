<?php

namespace App\Models;

use App\Exceptions\CaptchaSlotLimitReachedException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCaptcha extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'updated_at',
    ];

    private $slotLimit = 25;

    private static $rate = 0.05;

    public function account()
    {
        return $this->belongsTo(Account::class, 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public static function getRate()
    {
        return self::$rate;
    }

    public function getValidTime()
    {
        return Carbon::parse($this->updated_at)->addSeconds(15);
    }

    public function canUseCaptcha()
    {
        if ($this->updated_at != null && $this->getValidTime() >= now()) {
            return false;
        }
        return true;
    }

    public function useCaptcha()
    {
        if ($this->canUseCaptcha()) {
            $this->number_of_captcha += 1;
            if ($this->number_of_captcha > $this->slotLimit) {
                $this->number_of_captcha = 1;
                $this->save();
                throw new CaptchaSlotLimitReachedException();
            }
            return $this->updateCaptcha();
        }
        return false;
    }

    public function updateCaptcha()
    {
        $this->updated_at = now();
        return $this->save();
    }

    public function getRemainingTime()
    {
        $seconds = Carbon::now()->diffInSeconds($this->getValidTime());
        return "{$seconds} seconds";
    }
}
