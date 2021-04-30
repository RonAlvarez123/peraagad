<?php

namespace App\Services;

use App\Http\Requests\CashoutRequestIndexRequest;
use App\Models\Account;
use App\Models\Bank;
use App\Models\CashoutRequest;
use App\Models\Gcash;
use App\Models\Remit;

class CashoutService
{
    public static function indexGetCashoutRequests(CashoutRequestIndexRequest $request)
    {
        if ($request->type) {
            $cashoutrequests = CashoutRequest::with([
                'user' => function ($query) {
                    $query->select('user_id', 'firstname', 'lastname', 'account_code');
                }
            ])->where(['type' => $request->type, 'approved' => false])
                ->get();

            $cashoutrequests = ($request->order === 'old') ? $cashoutrequests->sortBy('requested_at') : $cashoutrequests->sortByDesc('requested_at');
            return $cashoutrequests;
        }

        return CashoutRequest::with([
            'user' => function ($query) {
                $query->select('user_id', 'firstname', 'lastname', 'account_code');
            }
        ])->where(['approved' => false])
            ->latest('requested_at')
            ->get();
    }

    public static function isCashoutApproved(CashoutRequest $cashoutRequest)
    {
        if ($cashoutRequest->approved == true) {
            abort(404);
        }
    }

    public static function getCashoutDetails(CashoutRequest $cashoutRequest)
    {
        if ($cashoutRequest->type === 'gcash') {
            return Gcash::where('cashout_id', $cashoutRequest->id)->first();
        } elseif ($cashoutRequest->type === 'bank') {
            return Bank::where('cashout_id', $cashoutRequest->id)->first();
        } elseif ($cashoutRequest->type === 'remit') {
            return Remit::where('cashout_id', $cashoutRequest->id)->first();
        }
    }

    public static function createCashoutRequest(Account $account, string $type, $request)
    {
        $cashout = [];
        $cashout['request'] = CashoutRequest::create([
            'user_id' => $account->user_id,
            'type' => $type,
            'total_amount' => $account->getTotalCashout(),
            'deducted_amount' => $account->getDeductedCashout(),
            'requested_at' => now(),
        ]);

        $validated = $request->validated();
        $validated['cashout_id'] = $cashout['request']->id;

        $cashout['type'] = Bank::create($validated);

        return $cashout;
    }

    public static function selectAccountForCashout()
    {
        return Account::select('id', 'user_id', 'money', 'role')->where('user_id', auth()->user()->user_id)->first();
    }
}
