<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashoutRequest extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'type',
        'total_amount',
        'deducted_amount',
        'updated_at',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function gcash()
    {
        return $this->hasOne(Gcash::class, 'cashout_id');
    }
}
