<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Http\Requests\UserRequest;
use App\Models\Account;
use App\Models\ColorGame;
use App\Models\Receipt;
use App\Models\User;
use App\Models\UserCaptcha;
use App\Rules\SpecialChars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $maxAttempts = 3; // Default is 5
    protected $decayMinutes = 2; // Default is 1

    public function index()
    {
        return view('auth.index');
    }

    public function show()
    {
        return view('auth.show');
    }

    public function store(UserRequest $request)
    {
        // --- WHEN CREATING AN ACCOUNT FOR AN ADMIN, CONVERT ALL CODES INTO COMMENTS FROM HERE ---
        // $validCode = Code::where([
        //     'account_code' => request()->input('account_code'),
        //     'used' => false
        // ])->first();

        // if (!$validCode) {
        //     return back()
        //         ->withInput()
        //         ->withErrors(['account_code' => 'You have entered an invalid code.']);
        // }
        // --- END OF COMMENT HERE ---

        // $validCode->setToUsed();

        $user = User::create([
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'phone_number' => $request->phone_number,
            'city' => $request->city,
            'province' => $request->province,
            'account_code' => $request->account_code,
            'password' => Hash::make($request->password),
            'created_at' => now(),
        ]);

        $user->setUserId();

        $account = Account::create([
            'user_id' => $user->user_id,
            // 'referrer_id' => $validCode->user_id, // MAKE THIS A COMMENT WHEN CREATING AN ACCOUNT FOR ADMIN

            'referrer_id' => null, // UNCOMMENT WHEN CREATING AN ACCOUNT FOR ADMIN
            // 'role' => request()->input('role'), // UNCOMMENT WHEN CREATING AN ACCOUNT FOR ADMIN
        ]);

        $account->getSignUpBonus(); // MAKE THIS A COMMENT WHEN CREATING AN ACCOUNT FOR ADMIN
        Helper::invites($account); // MAKE THIS A COMMENT WHEN CREATING AN ACCOUNT FOR ADMIN

        Receipt::create([
            'user_id' => $user->user_id,
        ]);

        UserCaptcha::create([
            'user_id' => $user->user_id,
        ]);

        ColorGame::create([
            'user_id' => $user->user_id,
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
        return back()
            ->withInput()
            ->withErrors([
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
