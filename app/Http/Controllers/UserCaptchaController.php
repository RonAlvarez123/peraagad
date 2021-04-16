<?php

namespace App\Http\Controllers;

use App\Exceptions\CaptchaSlotLimitReachedException;
use App\Models\Account;
use App\Models\Captcha;
use App\Models\UserCaptcha;
use App\Rules\SpecialChars;
use Illuminate\Http\Request;

class UserCaptchaController extends Controller
{
    public function edit()
    {
        $account = Account::select('user_id', 'money', 'direct', 'indirect', 'role')->where('user_id', auth()->user()->user_id)
            ->with([
                'userCaptcha' => function ($query) {
                    $query->select('user_id', 'number_of_captcha', 'updated_at');
                }
            ])
            ->first();
        return view('usercaptcha.edit')
            ->with('account', $account)
            ->with('captcha', Captcha::getRandomCaptcha());
    }

    public function update()
    {
        request()->validate([
            'value' => ['required', new SpecialChars],
        ]);

        $captcha = Captcha::select('value')->where('id', request()->input('id'))->first();
        if ($captcha && $captcha->value === request()->input('value')) {
            $account = Account::select('id', 'user_id', 'money')->where('user_id', auth()->user()->user_id)->first();
            $userCaptcha = $account->userCaptcha;
            try {
                $result = $userCaptcha->useCaptcha();
            } catch (CaptchaSlotLimitReachedException $exception) {
                $account->getMoney(UserCaptcha::getRate());
                $result = $userCaptcha->updateCaptcha();
            }
            if ($result) {
                return redirect()->route('usercaptcha.edit');
            }
        }
        return redirect()->route('usercaptcha.edit')->withErrors(['value' => 'You entered an invalid captcha.']);
    }
}
