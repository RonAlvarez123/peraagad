<?php

namespace App\Http\Controllers;

use App\Http\Requests\RemitStoreRequest;
use App\Models\Account;
use App\Models\Remit;
use App\Services\CashoutService;

class RemitController extends Controller
{
    public function create()
    {
        $account = Account::select('user_id', 'role')->where('user_id', auth()->user()->user_id)->first();
        return view('cashoutrequests.remit.create')
            ->with('account', $account)
            ->with('outlets', Remit::getOutlets());
    }

    public function store(RemitStoreRequest $request)
    {
        $account = CashoutService::selectAccountForCashout();

        if ($account->deductMoneyForCashoutRequest()) {
            $cashout = CashoutService::createCashoutRequest($account, 'remit', $request);

            return view('cashoutrequests.remit.summary')
                ->with('account', $account)
                ->with('cashoutRequest', $cashout['request'])
                ->with('remit', $cashout['type']);
        }
        return redirect()->route('profile.index')
            ->withErrors(['main_error' => 'Your balance is too low to cash out.']);
    }
}
