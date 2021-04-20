<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'cashout_id',
        'account_name',
        'account_number',
        'bank_name',
    ];
}
