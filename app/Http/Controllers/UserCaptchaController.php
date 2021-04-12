<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Captcha;
use Illuminate\Http\Request;

class UserCaptchaController extends Controller
{
    public function create()
    {
        return view('usercaptcha.create')
            ->with('account', Account::select('user_id', 'role')->where('user_id', session('loggedUserId'))->first())
            ->with('captcha', Captcha::getRandomCaptcha());
    }

    public function store()
    {
    }
}
