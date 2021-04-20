<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remit extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'cashout_id',
        'recipient_name',
        'phone_number',
        'municipality',
        'province',
        'address',
    ];
}
