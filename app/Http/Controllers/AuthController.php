<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
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
        $user = User::create(array_merge($request->validated(), ['password' => Hash::make($request->validated()['password']), 'created_at' => now()]));

        UserCreated::dispatch($user);

        return redirect()->route('auth.index')
            ->with('status', 'You have successfully registered an account.');
    }

    public function login(UserLoginRequest $request)
    {
        if (Auth::attempt(['account_code' => $request->account_code, 'password' => $request->password])) {
            request()->session()->regenerate();

            return auth()->user()->account->role === 'admin' ?
                redirect()->intended(route('coderequest.index')) :
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
