<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CodeRequest;
use App\Models\User;
use Illuminate\Http\Request;

class GetCodeController extends Controller
{
    public function index()
    {
        $account = Account::where('user_id', session('loggedUserId'))->first();
        return view('getcode.index')->with('account', $account)->with('codes', $account->codes()->where('used', false)->get());
    }

    public function create()
    {
        $user = User::find(session('loggedUserId'));
        return view('getcode.create')->with('user', $user)->with('account', $user->account);
    }

    public function store()
    {
        // return request()->input('number_of_codes');
        request()->validate([
            'number_of_codes' => ['required', 'gte:1', 'lte:9'],
        ]);

        CodeRequest::create([
            'user_id' => session('loggedUserId'),
            'number_of_codes' => request()->input('number_of_codes'),
        ]);

        return redirect()->route('getcode.create')->with('status', 'Code request complete.');
    }
}
