<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetCodeStoreRequest;
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
        $account = Account::select('user_id', 'money', 'level', 'direct', 'indirect', 'role')->where('user_id', auth()->user()->user_id)
            ->with([
                'codes' => function ($query) {
                    $query->select('user_id', 'account_code');
                }
            ])
            ->withCount(['timesRequestedForCode', 'codes'])
            ->first();

        return view('getcode.index')
            ->with('account', $account);
    }

    public function create()
    {
        return view('getcode.create')
            ->with('account', Account::select('money', 'direct', 'indirect', 'role')->where('user_id', auth()->user()->user_id)->first());
    }

    public function store(GetCodeStoreRequest $request)
    {
        if (!Hash::check($request->password, auth()->user()->password)) {
            return redirect()->route('getcode.create')
                ->withErrors(['password' => 'Incorrect Password'])
                ->withInput();
        }

        CodeRequest::create([
            'user_id' => auth()->user()->user_id,
            'number_of_codes' => $request->number_of_codes,
            'requested_at' => now(),
        ]);

        return redirect()->route('getcode.create')
            ->with('status', 'Code request complete.');
    }
}
