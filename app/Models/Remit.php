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
        'firstname',
        'middlename',
        'lastname',
        'phone_number',
        'municipality',
        'province',
        'address',
        'remittance_outlet'
    ];

    private static $outlets = [
        'cebuana lhuillier',
        'm lhuillier',
        'palawan express',
        'western union',
        'smart padala',
    ];

    public static function getOutlets()
    {
        return self::$outlets;
    }
}
