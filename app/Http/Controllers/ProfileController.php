<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::find(session('loggedUserId'), ['user_id', 'firstname', 'middlename', 'lastname', 'phone_number', 'city', 'province', 'account_code']);
        return view('profile.index')->with('user', $user)->with('account', $user->account);
    }

    public function logout()
    {
        if (session()->has('loggedUserId')) {
            session()->forget('loggedUserId');
            return redirect()->route('auth.index');
        }
    }
}
