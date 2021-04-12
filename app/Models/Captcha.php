<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Captcha extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'value',
        'path',
    ];

    public static function getRandomCaptcha()
    {
        return self::inRandomOrder()->first();
    }
}
