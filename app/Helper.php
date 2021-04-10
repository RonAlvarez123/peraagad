<?php

namespace App;

use App\Models\Account;

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

    public static function invites(Account $account) // pang indirect - kelangan pa puliduhin
    {
        for ($i = 1; $i <= 6; $i++) {
            if ($account->referrer_id === null) {
                break;
            }
            $account = $account->getReferrerAccount;
            if ($i === 1) {
                $account->addDirectInvite();
            } else {
                $account->addIndirectInvite();
            }
        }
        return 'no Errors';
    }
}
