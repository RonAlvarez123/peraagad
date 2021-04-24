<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashoutRequestIndexRequest;
use App\Models\Account;
use App\Models\Bank;
use App\Models\CashoutRequest;
use App\Models\Gcash;
use App\Models\Remit;
use App\Models\User;
use Illuminate\Http\Request;

class CashoutRequestController extends Controller
{
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

    public function index(CashoutRequestIndexRequest $request)
    {
        $account = Account::select('user_id', 'role')->where('user_id', auth()->user()->user_id)->first();

        if ($request->type) {
            $cashoutrequests = CashoutRequest::with([
                'user' => function ($query) {
                    $query->select('user_id', 'firstname', 'lastname', 'account_code');
                }
            ])->where('type', $request->type)
                ->get();

            $cashoutrequests = ($request->order === 'old') ? $cashoutrequests->sortBy('requested_at') : $cashoutrequests->sortByDesc('requested_at');
        } else {
            $cashoutrequests = CashoutRequest::with([
                'user' => function ($query) {
                    $query->select('user_id', 'firstname', 'lastname', 'account_code');
                }
            ])->latest('requested_at')->get();
        }

        return view('cashoutrequests.admin.index')
            ->with('account', $account)
            ->with('cashoutrequests', $cashoutrequests);
    }

    public function show(CashoutRequest $cashoutRequest)
    {
        if ($cashoutRequest->type === 'gcash') {
            $cashoutDetails = Gcash::where('cashout_id', $cashoutRequest->id)->first();
        } elseif ($cashoutRequest->type === 'bank') {
            $cashoutDetails = Bank::where('cashout_id', $cashoutRequest->id)->first();
        } elseif ($cashoutRequest->type === 'remit') {
            $cashoutDetails = Remit::where('cashout_id', $cashoutRequest->id)->first();
        }

        return view('cashoutrequests.admin.show')
            ->with('account', Account::select('user_id', 'role')->where('user_id', auth()->user()->user_id)->first())
            ->with('user', User::select('user_id', 'firstname', 'middlename', 'lastname', 'phone_number', 'account_code')->where('user_id', $cashoutRequest->user_id)->first())
            ->with('cashoutrequest', $cashoutRequest)
            ->with('cashoutDetails', $cashoutDetails);
    }
}
