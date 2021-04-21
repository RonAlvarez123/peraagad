<?php

namespace App\Models;

use Carbon\Carbon;
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

    /*
    *-------------------------
    * MAKE THE RATE HALF, WHEN NUMBER OF TIMES PLAYED REACHES FULL RATE LIMIT 
    *-------------------------
    */
    private $peak = 10;

    private $rate = [
        'min' => 20,
        'max' => 50
    ];

    private $playResult = '';

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

    public static function getRewardIds()
    {
        $rewardIds = [];
        $rewards = self::getRewards();
        foreach ($rewards as $reward) {
            $rewardIds[] = $reward['id'];
        }
        return $rewardIds;
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

    public function getValidTime()
    {
        return Carbon::parse($this->updated_at)->addMinute(2);
    }

    public function canPlay()
    {
        if ($this->updated_at != null && $this->getValidTime() >= now()) {
            return false;
        }
        return true;
    }

    public function play()
    {
        if ($this->canPlay()) {
            $recieved = 0;
            $multiplier = 0;
            $rate = 0;
            $this->number_of_times_played += 1;

            if ($this->number_of_times_played % $this->peak === 0) {
                $multiplier = $this->multiplier;
                $rate = $this->rate['max'];
                $recieved = $rate * $multiplier;
            } else {
                $multiplier = $this->multiplier;
                $rate = $this->rate['min'];
                $recieved = $rate * $multiplier;
            }

            $this->points += $recieved;
            $this->updated_at = now();
            $result = $this->save();
            if ($result) {
                $this->playResult = "You recieved {$rate} points times {$multiplier} total of {$recieved} points.";
                return true;
            }
        }
        return false;
    }

    public function getPlayResult()
    {
        return $this->playResult;
    }

    public function reducePoints($value)
    {
        $this->points -= $value;
        return $this->save();
    }

    public function getRemainingTime()
    {
        $result = now()->diffInRealMinutes($this->getValidTime()) / 60;
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
