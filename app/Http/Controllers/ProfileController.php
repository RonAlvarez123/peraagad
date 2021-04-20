<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::select('user_id', 'firstname', 'middlename', 'lastname', 'phone_number', 'city', 'province', 'account_code', 'created_at', 'updated_at')->where('id', auth()->user()->user_id)
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

    public function update()
    {
        request()->validate([
            'old_password' => ['required'],
            'new_password' => ['required', 'min:6', 'confirmed'],
        ]);

        $user = User::select('id', 'user_id', 'password', 'updated_at')->where('user_id', auth()->user()->user_id)->first();

        if (!Hash::check(request()->input('old_password'), $user->password)) {
            return redirect()->route('profile.index')
                ->withErrors([
                    'old_password' => 'The password is incorrect.',
                    'main_error' => 'Password change failed.',
                ]);
        } elseif (Hash::check(request()->input('new_password'), $user->password)) {
            return redirect()->route('profile.index')
                ->withErrors([
                    'new_password' => 'The new password is the same as the old password.',
                    'main_error' => 'Password change failed.',
                ]);
        }

        if ($user->changePassword(request()->input('new_password'))) {
            return redirect()->route('profile.index')
                ->with('status', 'You have changed your password.');
        }

        return redirect()->route('profile.index')
            ->withErrors(['main_error' => 'Password change failed.']);
    }
}
