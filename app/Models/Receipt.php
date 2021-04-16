<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'updated_at',
    ];

    private static $partners = [
        'puregold',
        'ever',
        'ultramega',
        'sm supermarket',
        'meralco',
        'pldt',
        'converge',
        'primewater',
        'nawasa',
        'bayad center',
    ];

    private static $rate = 3;

    public function account()
    {
        return $this->belongsTo(Account::class, 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public static function getPartners()
    {
        return self::$partners;
    }

    public static function getRate()
    {
        return self::$rate;
    }

    public function canUploadReceipt()
    {
        if ($this->updated_at != null && Carbon::parse($this->updated_at)->addHours(8) >= now()) {
            return false;
        }
        return true;
    }

    public function updateReceipt()
    {
        if ($this->canUploadReceipt()) {
            $this->updated_at = now();
            return $this->save();
        }
        return false;
    }

    public function getRemainingTime()
    {
        $result = Carbon::now()->diffInRealMinutes(Carbon::parse($this->updated_at)->addHours(8)->addSeconds(2)) / 60;
        $time = explode('.', $result);
        $hours = $time[0];
        $minutes = 0;
        if (array_key_exists('1', $time)) {
            $minutes = (substr($time[1], 0, 2) * .01) * 60;
            $minutes = (int)round($minutes);
        }
        return "{$hours} hours and {$minutes} minutes";
    }
}
