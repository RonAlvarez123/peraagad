<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'updated_at',
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

    public static function getRate()
    {
        return self::$rate;
    }

    public function updateRecipe()
    {
        if ($this->updated_at != null && Carbon::parse($this->updated_at)->addDays(1) >= now()) {
            return false;
        }
        $this->updated_at = now();
        return $this->save();
    }
}
