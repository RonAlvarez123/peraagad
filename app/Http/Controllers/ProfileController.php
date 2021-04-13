<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::select('user_id', 'firstname', 'middlename', 'lastname', 'phone_number', 'city', 'province', 'account_code')->where('id', auth()->user()->user_id)
            ->with([
                'account' => function ($query) {
                    $query->select('user_id', 'money', 'level', 'direct', 'indirect', 'role');
                }
            ])->first();

        return view('profile.index')->with('user', $user)->with('account', $user->account);
    }
}
