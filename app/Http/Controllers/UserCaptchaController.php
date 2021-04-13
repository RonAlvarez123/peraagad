<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Captcha;
use App\Rules\SpecialChars;
use Illuminate\Http\Request;

class UserCaptchaController extends Controller
{
    public function create()
    {
        return view('usercaptcha.create')
            ->with('account', Account::select('user_id', 'money', 'direct', 'indirect', 'role')->where('user_id', auth()->user()->user_id)->first())
            ->with('captcha', Captcha::getRandomCaptcha());
    }

    public function store()
    {
        request()->validate([
            'value' => ['required', new SpecialChars],
        ]);

        $captcha = Captcha::select('value')->where('id', request()->input('id'))->first();
        if ($captcha && $captcha->value === request()->input('value')) {
            $account = Account::select('id', 'money')->where('user_id', auth()->user()->user_id)->first();
            $account->getMoneyFromCaptcha($captcha->getCaptchaRate());
            return redirect()->route('usercaptcha.create');
        }
        return redirect()->route('usercaptcha.create')->withErrors(['value' => 'You entered an invalid captcha.']);
    }
}
