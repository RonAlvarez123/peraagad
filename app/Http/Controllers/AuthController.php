<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Account;
use App\Models\CaptchaCredit;
use App\Models\Code;
use App\Models\User;
use App\Rules\SpecialChars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function show()
    {
        // $account = Account::where('user_id', 3)->first();
        // return $account->addDirectInvite();
        return view('auth.show');
    }

    public function store()
    {
        // --- WHEN CREATING AN ACCOUNT FOR AN ADMIN, CONVERT ALL CODES INTO COMMENTS FROM HERE ---
        $validCode = Code::where([
            'account_code' => request()->input('account_code'),
            'used' => false
        ])->first();

        if (!$validCode) {
            return back()->withErrors(['account_code' => 'You have entered an invalid code.']);
        }
        // --- END OF COMMENT HERE ---

        request()->validate([
            'firstname' => ['required', 'min:3', new SpecialChars],
            'middlename' => ['required', 'min:3', new SpecialChars],
            'lastname' => ['required', 'min:3', new SpecialChars],
            'phone_number' => ['required', 'unique:users', 'min:11', 'max:11', 'starts_with:09'],
            'city' => ['required', 'min:3', new SpecialChars],
            'province' => ['required', 'min:3', new SpecialChars],
            'account_code' => ['required', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:5'],

            // 'role' => ['required', 'in:user,moderator,admin'], // UNCOMMENT WHEN CREATING AN ACCOUNT FOR ADMIN
        ]);

        $validCode->setToUsed();

        $user = User::create([
            'firstname' => request()->input('firstname'),
            'middlename' => request()->input('middlename'),
            'lastname' => request()->input('lastname'),
            'phone_number' => request()->input('phone_number'),
            'city' => request()->input('city'),
            'province' => request()->input('province'),
            'account_code' => request()->input('account_code'),
            'password' => Hash::make(request()->input('password')),
        ]);

        $user->setUserId();

        $account = Account::create([
            'user_id' => $user->user_id,
            'referrer_id' => $validCode->user_id, // MAKE THIS A COMMENT WHEN CREATING AN ACCOUNT FOR ADMIN

            // 'referrer_id' => null, // UNCOMMENT WHEN CREATING AN ACCOUNT FOR ADMIN
            // 'role' => request()->input('role'), // UNCOMMENT WHEN CREATING AN ACCOUNT FOR ADMIN
        ]);

        $account->getSignUpBonus(); // MAKE THIS A COMMENT WHEN CREATING AN ACCOUNT FOR ADMIN
        Helper::invites($account); // MAKE THIS A COMMENT WHEN CREATING AN ACCOUNT FOR ADMIN

        CaptchaCredit::create([
            'user_id' => $user->user_id,
            'updated_at' => now(),
        ]);

        return redirect()->route('auth.index')->with('status', 'You have successfully registered an account.');
    }

    public function login()
    {
        request()->validate([
            'account_code' => ['required'],
            'password' => ['required', 'min:5'],
        ]);

        $credentials = request()->only('account_code', 'password');

        if (Auth::attempt($credentials)) {
            request()->session()->regenerate();

            return auth()->user()->account->role === 'admin' ? redirect()->intended(route('coderequest.index')) :
                redirect()->intended(route('profile.index'));
        }
        return redirect()->back()->withErrors([
            'account_code' => 'Account Code or Password is Incorrect.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('auth.index');
    }
}
