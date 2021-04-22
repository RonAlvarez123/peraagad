<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'account_code',
    ];

    private static $price = 300;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'user_id', 'user_id');
    }

    public function setToUsed()
    {
        $this->used = true;
        return $this->save();
    }

    public static function getPrice()
    {
        return self::$price;
    }
}
