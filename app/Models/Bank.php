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
        'bank_partner',
    ];

    private static $partners = [
        'asia united bank',
        'BDO network bank',
        'BDO unibank inc',
        'BPI/BPI family savings bank',
        'china bank savings inc',
        'china banking corporation',
        'CIMB bank philippines',
        'eastWest rural bank',
        'land bank of the philippines',
        'metropolitan bank and trust co',
        'philippine national bank',
        'philippine savings bank',
        'PNB savings bank',
        'RCBC savings bank',
        'security bank corporation',
        'UCPB savings bank',
        'union bank of the philippines',
    ];

    public static function getPartners()
    {
        return self::$partners;
    }

    public function cashoutRequest()
    {
        return $this->belongsTo(CashoutRequest::class, 'cashout_id');
    }
}
