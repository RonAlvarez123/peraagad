<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::select('user_id', 'firstname', 'middlename', 'lastname', 'phone_number', 'city', 'province', 'account_code')->where('id', auth()->user()->user_id)
            ->with([
                'account' => function ($query) {
                    $query->select('user_id', 'money', 'level', 'direct', 'indirect', 'role', 'bonus_claimed_at', 'number_of_bonus_claimed');
                }
            ])->first();
        return view('profile.index')->with('user', $user)->with('account', $user->account);
    }

    public function bonus()
    {
        $account = Account::select('id', 'user_id', 'money', 'number_of_bonus_claimed', 'bonus_claimed_at')->where('user_id', auth()->user()->user_id)->first();
        if ($account->getDailyBonus()) {
            return redirect()->route('profile.index')
                ->with('status', 'You have claimed your daily bonus.');
        }
        return redirect()->route('profile.index');
    }
}
