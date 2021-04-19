<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashout extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'account_name',
        'account_number',
        'bank_name',
        'recipient_name',
        'phone_number',
        'municipality',
        'province',
        'address',
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
}
