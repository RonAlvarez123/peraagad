<?php

namespace App\Models;

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

    private static $receiptPartners = [
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

    private $receiptRate = 1;

    public function account()
    {
        return $this->belongsTo(Account::class, 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public static function getReceiptPartners()
    {
        return self::$receiptPartners;
    }
}
