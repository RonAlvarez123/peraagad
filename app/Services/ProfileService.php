<?php

namespace App\Services;

class ProfileService
{
    public static function getMainError()
    {
        return ['main_error' => 'Password change failed.'];
    }
}
