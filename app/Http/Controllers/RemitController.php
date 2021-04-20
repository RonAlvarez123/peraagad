<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Http\Requests\RemitRequest;
use App\Models\Account;
use App\Models\CashoutRequest;
use App\Models\Remit;
use Illuminate\Http\Request;

class RemitController extends Controller
{
    public function create()
    {
        $account = Account::select('user_id', 'role')->where('user_id', auth()->user()->user_id)->first();
        return view('cashoutrequests.remit.create')->with('account', $account);
    }

    public function store(RemitRequest $request)
    {
        if (Helper::passwordMatch($request->password)) {
            $account = Account::select('id', 'user_id', 'money', 'role')->where('user_id', auth()->user()->user_id)->first();

            if ($account->createCashoutRequest()) {
                $cashoutRequest = CashoutRequest::create([
                    'user_id' => $account->user_id,
                    'type' => 'remit',
                    'total_amount' => $account->getTotalCashout(),
                    'deducted_amount' => $account->getDeductedCashout(),
                    'requested_at' => now(),
                ]);

                $remit = Remit::create([
                    'cashout_id' => $cashoutRequest->id,
                    'firstname' => $request->firstname,
                    'middlename' => $request->middlename,
                    'lastname' => $request->lastname,
                    'phone_number' => $request->phone_number,
                    'municipality' => $request->municipality,
                    'province' => $request->province,
                    'address' => $request->address,
                ]);

                return view('cashoutrequests.remit.summary')
                    ->with('account', $account)
                    ->with('cashoutRequest', $cashoutRequest)
                    ->with('remit', $remit);
            }
            return redirect()->route('profile.index')
                ->withErrors(['main_error' => 'Your balance is too low to cash out.']);
        }
        return redirect()->route('remit.create')
            ->withInput()
            ->withErrors(['password' => 'The password is incorrect']);
    }
}
