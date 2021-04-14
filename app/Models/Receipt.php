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

    private static $rate = 1;

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

    public function updateReceipt()
    {
        if ($this->updated_at != null && Carbon::parse($this->updated_at)->addMinutes(30) >= now()) {
            return false;
        }
        $this->updated_at = now();
        return $this->save();
    }
}
