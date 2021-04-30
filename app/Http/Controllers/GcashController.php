<?php

namespace App\Http\Controllers;

use App\Http\Requests\GcashStoreRequest;
use App\Models\Account;
use App\Services\CashoutService;

class GcashController extends Controller
{
    public function create()
    {
        $account = Account::select('user_id', 'role')->where('user_id', auth()->user()->user_id)->first();
        return view('cashoutrequests.gcash.create')
            ->with('account', $account);
    }

    public function store(GcashStoreRequest $request)
    {
        $account = CashoutService::selectAccountForCashout();

        if ($account->deductMoneyForCashoutRequest()) {
            $cashout = CashoutService::createCashoutRequest($account, 'gcash', $request);

            return view('cashoutrequests.gcash.summary')
                ->with('account', $account)
                ->with('cashoutRequest', $cashout['request'])
                ->with('gcash', $cashout['type']);
        }
        return redirect()->route('profile.index')
            ->withErrors(['main_error' => 'Your balance is too low to cash out.']);
    }
}
