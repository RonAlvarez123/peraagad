<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorGame extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'updated_at',
    ];

    private static $rewards = [
        [
            'id' => 1,
            'points' => '5000',
            'money' => '100'
        ],
        [
            'id' => 2,
            'points' => '20000',
            'money' => '500'
        ],
        [
            'id' => 3,
            'points' => '100000',
            'money' => '3000'
        ],
        [
            'id' => 4,
            'points' => '500000',
            'money' => '18000'
        ],
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public static function getRewards()
    {
        return self::$rewards;
    }

    public function setMultiplier($directInvites)
    {
        if ($directInvites >= 1 && $directInvites <= 4) {
            $this->multiplier = '1.5';
        } elseif ($directInvites >= 5 && $directInvites <= 9) {
            $this->multiplier = '2';
        } elseif ($directInvites >= 10) {
            $this->multiplier = '3';
        }
        return $this->save();
    }
}
