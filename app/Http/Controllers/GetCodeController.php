<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CodeRequest;
use App\Rules\SpecialChars;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GetCodeController extends Controller
{
    public function index()
    {
        // I should test the difference of -- $account->timesRequestedForCode()->count() VS $account->timesRequestedForCode->count() //
        $account = Account::select('user_id', 'money', 'level', 'direct', 'indirect', 'role')->where('user_id', auth()->user()->user_id)  // NEW
            ->with([
                'codes' => function ($query) {
                    $query->select('user_id', 'account_code')->where('used', false);
                }
            ])
            ->withCount(['timesRequestedForCode', 'codes'])
            ->first();
        // return $account->codes . $account->hasCodes();

        return view('getcode.index')->with('account', $account);
    }

    public function create()
    {
        return view('getcode.create')->with('account', Account::select('money', 'direct', 'indirect', 'role')->where('user_id', auth()->user()->user_id)->first());
    }

    public function store()
    {
        request()->validate([
            'number_of_codes' => ['required', 'gte:1', 'lte:9'],
            'password' => ['required', new SpecialChars]
        ]);

        if (!Hash::check(request()->input('password'), auth()->user()->password)) {
            return redirect()->route('getcode.create')
                ->withErrors(['password' => 'Incorrect Password']);
        }

        CodeRequest::create([
            'user_id' => auth()->user()->user_id,
            'number_of_codes' => request()->input('number_of_codes'),
            'requested_at' => Carbon::now()->toDateTimeString(),
        ]);

        return redirect()->route('getcode.create')->with('status', 'Code request complete.');
    }
}
