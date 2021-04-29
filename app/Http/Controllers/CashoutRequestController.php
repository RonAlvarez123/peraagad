<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashoutRequestDestroyRequest;
use App\Http\Requests\CashoutRequestIndexRequest;
use App\Http\Requests\CashoutRequestUpdateRequest;
use App\Models\Account;
use App\Models\CashoutRequest;
use App\Models\User;
use App\Services\CashoutService;

class CashoutRequestController extends Controller
{
    public function index(CashoutRequestIndexRequest $request)
    {
        return view('cashoutrequests.admin.index')
            ->with('account', Account::select('user_id', 'role')->where('user_id', auth()->user()->user_id)->first())
            ->with('cashoutrequests', CashoutService::indexGetCashoutRequests($request));
    }

    public function show(CashoutRequest $cashoutRequest)
    {
        CashoutService::isCashoutApproved($cashoutRequest);

        return view('cashoutrequests.admin.show')
            ->with('account', Account::select('user_id', 'role')->where('user_id', auth()->user()->user_id)->first())
            ->with('user', User::select('user_id', 'firstname', 'middlename', 'lastname', 'phone_number', 'account_code')->where('user_id', $cashoutRequest->user_id)->first())
            ->with('cashoutrequest', $cashoutRequest)
            ->with('cashoutDetails', CashoutService::getCashoutDetails($cashoutRequest));
    }

    public function update(CashoutRequest $cashoutRequest, CashoutRequestUpdateRequest $request)
    {
        $cashoutRequest->approve();

        return redirect()->route('cashoutrequest.index')
            ->with('acceptMessage', 'You have successfully approved a cashout request.');
    }

    public function destroy(CashoutRequest $cashoutRequest, CashoutRequestDestroyRequest $request)
    {
        CashoutRequest::destroy($cashoutRequest->id);

        return redirect()->route('cashoutrequest.index')
            ->with('declineMessage', 'You have successfully declined and deleted a cashout request.');
    }

    public function redirect()
    {
        $method = request()->input('method');
        switch ($method) {
            case 'gcash':
                return redirect()->route('gcash.create');
                break;
            case 'bank':
                return redirect()->route('bank.create');
                break;
            case 'remit':
                return redirect()->route('remit.create');
                break;
            default:

                break;
        }
    }
}
