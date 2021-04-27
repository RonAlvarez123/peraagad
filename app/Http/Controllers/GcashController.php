<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Http\Requests\GcashStoreRequest;
use App\Models\Account;
use App\Models\CashoutRequest;
use App\Models\Gcash;
use Illuminate\Http\Request;

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
        if (Helper::passwordMatch($request->password)) {
            $account = Account::select('id', 'user_id', 'money', 'role')->where('user_id', auth()->user()->user_id)->first();

            if ($account->createCashoutRequest()) {
                $cashoutRequest = CashoutRequest::create([
                    'user_id' => $account->user_id,
                    'type' => 'gcash',
                    'total_amount' => $account->getTotalCashout(),
                    'deducted_amount' => $account->getDeductedCashout(),
                    'requested_at' => now(),
                ]);

                $gcash = Gcash::create([
                    'cashout_id' => $cashoutRequest->id,
                    'account_name' => $request->account_name,
                    'account_number' => $request->account_number,
                ]);

                return view('cashoutrequests.gcash.summary')
                    ->with('account', $account)
                    ->with('cashoutRequest', $cashoutRequest)
                    ->with('gcash', $gcash);
            }
            return redirect()->route('profile.index')
                ->withErrors(['main_error' => 'Your balance is too low to cash out.']);
        }
        return redirect()->route('gcash.create')
            ->withInput()
            ->withErrors(['password' => 'The password is incorrect']);
    }
}
