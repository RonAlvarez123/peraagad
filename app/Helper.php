<?php

namespace App;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class Helper
{
    public static function randomString($n, $suffix)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $characters = '0123456789';
        $str = '';
        for ($i = 1; $i < $n + 1; $i++) {
            if ($i % 4 === 0) {
                $str .= '-';
            } else {
                $index = rand(0, strlen($characters) - 1);
                $str .= $characters[$index];
            }
        }

        $str .= '-' . $suffix;

        return $str;
    }
}
