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
        // $account = Account::where('user_id', session('loggedUserId'))->first(); // OLD
        // return $account . '<br>' . $account->timesRequestedForCode()->count();


        $account = Account::where('user_id', session('loggedUserId'))  // NEW
            ->with([
                'codes' => function ($query) {
                    $query->where('used', false);
                }
            ])
            ->withCount(['timesRequestedForCode', 'codes'])
            ->first();

        // I should test the difference of -- $account->timesRequestedForCode()->count() VS $account->timesRequestedForCode->count() //
        return view('getcode.index')->with('account', $account);
    }

    public function create()
    {
        // $user = User::find(session('loggedUserId'));
        $user = User::select('user_id')->where('id', session('loggedUserId'))
            ->with([
                'account' => function ($query) {
                    $query->select('user_id', 'money', 'direct', 'indirect', 'role');
                }
            ])
            ->first();
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
