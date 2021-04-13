<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Account;
use App\Models\Captcha;
use App\Rules\SpecialChars;
use Illuminate\Http\Request;

class AdminCaptchaController extends Controller
{
    public function create()
    {
        return view('admincaptcha.create')
            ->with('account', Account::select('user_id', 'role')->where('user_id', auth()->user()->user_id)->first());
    }

    public function store()
    {
        request()->validate([
            'value' => ['required', 'min:6', new SpecialChars],
            'file' => ['required', 'mimetypes:image/svg,image/svg+xml'],
        ]);

        request()->file('file')->storeAs('public/captcha', $filePath = Helper::renameFile('/captcha', request()->file('file')->getClientOriginalName()));

        $captcha = Captcha::create([
            'value' => request()->input('value'),
            'path' => $filePath,
        ]);

        if (!$captcha) {
            return redirect()->route('admincaptcha.create')
                ->withErrors(['value' => 'Captcha addition failed.']);
        }

        return redirect()->route('admincaptcha.create')
            ->with('status', 'Captcha added successfuly.');
    }
}
