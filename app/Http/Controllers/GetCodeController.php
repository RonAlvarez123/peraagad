<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CodeRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GetCodeController extends Controller
{
    public function index()
    {
        $account = Account::where('user_id', session('loggedUserId'))->first();
        // return $account . '<br>' . $account->timesRequestedForCode()->count();
        // I should test the difference of -- $account->timesRequestedForCode()->count() VS $account->timesRequestedForCode->count() //
        return view('getcode.index')
            ->with('account', $account)
            ->with('codes', $account->codes()->where('used', false)->get())
            ->with('times_requested_for_code', $account->timesRequestedForCode()->count());
    }

    public function create()
    {
        $user = User::find(session('loggedUserId'));
        return view('getcode.create')->with('user', $user)->with('account', $user->account);
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
