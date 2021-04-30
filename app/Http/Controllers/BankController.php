<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankStoreRequest;
use App\Models\Account;
use App\Models\Bank;
use App\Services\CashoutService;

class BankController extends Controller
{
    public function create()
    {
        $account = Account::select('user_id', 'role')->where('user_id', auth()->user()->user_id)->first();
        return view('cashoutrequests.bank.create')
            ->with('account', $account)
            ->with('partners', Bank::getPartners());
    }

    public function store(BankStoreRequest $request)
    {
        $account = CashoutService::selectAccountForCashout();

        if ($account->deductMoneyForCashoutRequest()) {
            $cashout = CashoutService::createCashoutRequest($account, 'bank', $request);

            return view('cashoutrequests.bank.summary')
                ->with('account', $account)
                ->with('cashoutRequest', $cashout['request'])
                ->with('bank', $cashout['type']);
        }
        return redirect()->route('profile.index')
            ->withErrors(['main_error' => 'Your balance is too low to cash out.']);
    }
}
