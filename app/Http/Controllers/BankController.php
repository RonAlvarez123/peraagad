<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Http\Requests\BankRequest;
use App\Models\Account;
use App\Models\Bank;
use App\Models\CashoutRequest;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function create()
    {
        $account = Account::select('user_id', 'role')->where('user_id', auth()->user()->user_id)->first();
        return view('cashoutrequests.bank.create')->with('account', $account);
    }

    public function store(BankRequest $request)
    {
        if (Helper::passwordMatch($request->password)) {
            $account = Account::select('id', 'user_id', 'money', 'role')->where('user_id', auth()->user()->user_id)->first();

            if ($account->createCashoutRequest()) {
                $cashoutRequest = CashoutRequest::create([
                    'user_id' => $account->user_id,
                    'type' => 'bank',
                    'total_amount' => $account->getTotalCashout(),
                    'deducted_amount' => $account->getDeductedCashout(),
                    'requested_at' => now(),
                ]);

                $bank = Bank::create([
                    'cashout_id' => $cashoutRequest->id,
                    'account_name' => $request->account_name,
                    'account_number' => $request->account_number,
                    'bank_name' => $request->bank_name,
                ]);

                return view('cashoutrequests.bank.summary')
                    ->with('account', $account)
                    ->with('cashoutRequest', $cashoutRequest)
                    ->with('bank', $bank);
            }
            return redirect()->route('profile.index')
                ->withErrors(['main_error' => 'Your balance is too low to cash out.']);
        }
        return redirect()->route('bank.create')
            ->withInput()
            ->withErrors(['password' => 'The password is incorrect']);
    }
}
