<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gcash extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'cashout_id',
        'account_name',
        'account_number',
    ];

    public function cashoutRequest()
    {
        return $this->belongsTo(CashoutRequest::class, 'cashout_id');
    }
}
