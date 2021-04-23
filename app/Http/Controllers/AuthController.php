<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\Account;
use App\Models\Code;
use App\Models\ColorGame;
use App\Models\Receipt;
use App\Models\User;
use App\Models\UserCaptcha;
use App\Services\AccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function create()
    {
        return view('auth.create');
    }

    public function store(UserStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $validated['created_at'] = now();

        $user = User::create($validated);
        $user->setUserId();

        $validCode = Code::where(['account_code' => $validated['account_code'], 'used' => false])->first(); // MAKE THIS A COMMENT WHEN CREATING AN ACCOUNT FOR ADMIN
        $validCode->setToUsed(); // MAKE THIS A COMMENT WHEN CREATING AN ACCOUNT FOR ADMIN
        $accountValue = AccountService::getAccountValue($user->id /*, true, $validCode->user_id*/); // if with referral, add true as 2nd param and add the referrer_id as 3rd param
        $accountValue = AccountService::getAccountValue($user->id, true, $validCode->user_id);
        $account = Account::create($accountValue);

        if (!request()->has('role')) {
            $account->getSignUpBonus();
            AccountService::invites($account);
        }

        $userId = ['user_id' => $user->user_id];
        Receipt::create($userId);
        UserCaptcha::create($userId);
        ColorGame::create($userId);

        return redirect()->route('auth.index')
            ->with('status', 'You have successfully registered an account.');
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['account_code' => $request->account_code, 'password' => $request->password])) {
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
