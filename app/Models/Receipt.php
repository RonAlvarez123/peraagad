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

    private static $categories = [
        'grocery receipt',
        'electric bill',
        'water bill',
        'internet bill',
        'bus ticket',
        'home appliances receipt',
        'furniture receipt',
        'bookstore receipt',
        'fast food receipt',
        'restaurant receipt',
        'LRT ticket',
        'MRT ticket',
        'money remittance receipt',
        'jewelry store receipt',
        'clothes and accessories receipt',
    ];

    private $fullRateLimit = 90;

    private static $rate = 3;

    public function account()
    {
        return $this->belongsTo(Account::class, 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public static function getCategories()
    {
        return self::$categories;
    }

    public static function getRate()
    {
        return self::$rate;
    }

    public function getValidTime()
    {
        return Carbon::parse($this->updated_at)->addMinute(2);
    }

    public function canUploadReceipt()
    {
        if ($this->updated_at != null && $this->getValidTime() >= now()) {
            return false;
        }
        return true;
    }

    public function updateReceipt()
    {
        if ($this->canUploadReceipt()) {
            if ($this->number_of_times_uploaded > $this->fullRateLimit) {
                self::$rate = 2;
            }
            $this->updated_at = now();
            return $this->save();
        }
        return false;
    }

    public function getRemainingTime()
    {
        $result = Carbon::now()->diffInRealMinutes($this->getValidTime()) / 60;
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
