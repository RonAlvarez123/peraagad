<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\Account;
use App\Models\Code;
use App\Models\ColorGame;
use App\Models\Receipt;
use App\Models\UserCaptcha;
use App\Services\AccountService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $event->user->setUserId();

        if ($validCode = Code::where(['account_code' => $event->user->account_code, 'used' => false])->first()) {
            $validCode->setToUsed();
            $accountValue = AccountService::getAccountValue($event->user->id, true, $validCode->user_id);
        } else {
            $accountValue = AccountService::getAccountValue($event->user->id);
        }

        $account = Account::find(Account::create($accountValue)->id);

        if ($account->role === 'user') {
            $account->getSignUpBonus();
            AccountService::invites($account);
        }

        $userId = ['user_id' => $account->user_id];
        Receipt::create($userId);
        UserCaptcha::create($userId);
        ColorGame::create($userId);
    }
}
