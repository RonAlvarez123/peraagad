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

    private $captchaRate = 0.02;

    public static function getRandomCaptcha()
    {
        return self::inRandomOrder()->first();
    }

    public function getCaptchaRate()
    {
        return $this->captchaRate;
    }
}
