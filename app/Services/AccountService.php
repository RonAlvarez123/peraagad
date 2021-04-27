<?php

namespace App\Services;

use App\Models\Account;

class AccountService
{
    /**
     * Create account based on role and if referral has value.
     * 
     * @param  $id - userId
     * @param  bool $withRefferal - toggle this to true if you want to create an account that is reffered by an existing user
     * @param int $referrer_id - if $withRefferal is true, set a value for $referrer_id
     * @return array AccountValue
     */
    public static function getAccountValue($id, $withRefferal = false, $referrer_id = null)
    {
        if ($withRefferal) {
            return [
                'user_id' => $id,
                'referrer_id' => $referrer_id,
            ];
        }

        if (request()->has('role')) {
            return [
                'user_id' => $id,
                'referrer_id' => $referrer_id,
                'role' => request()->input('role'),
            ];
        }

        return [
            'user_id' => $id,
            'referrer_id' => $referrer_id,
        ];
    }

    public static function invites(Account $account)
    {
        for ($i = 1; $i <= 6; $i++) {
            if ($account->referrer_id === null) {
                break;
            }
            $account = $account->getReferrerAccount;
            if ($i === 1) {
                $account->addDirectInvite();
                $account->colorGame->setMultiplier($account->direct);
            } else {
                $account->addIndirectInvite();
            }
        }
    }
}
