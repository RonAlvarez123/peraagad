<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CodeRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GetCodeController extends Controller
{
    public function index()
    {
        // I should test the difference of -- $account->timesRequestedForCode()->count() VS $account->timesRequestedForCode->count() //
        return view('getcode.index')->with('account', Account::select('user_id', 'money', 'level', 'direct', 'indirect', 'role')->where('user_id', session('loggedUserId'))  // NEW
            ->with([
                'codes' => function ($query) {
                    $query->select('user_id', 'account_code')->where('used', false);
                }
            ])
            ->withCount(['timesRequestedForCode', 'codes'])
            ->first());
    }

    public function create()
    {
        return view('getcode.create')->with('account', Account::select('money', 'direct', 'indirect', 'role')->where('user_id', session('loggedUserId'))->first());
    }

    public function store()
    {
        request()->validate([
            'number_of_codes' => ['required', 'gte:1', 'lte:9'],
        ]);

        CodeRequest::create([
            'user_id' => session('loggedUserId'),
            'number_of_codes' => request()->input('number_of_codes'),
            'requested_at' => Carbon::now()->toDateTimeString(),
        ]);

        return redirect()->route('getcode.create')->with('status', 'Code request complete.');
    }
}
