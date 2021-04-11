<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Account;
use App\Rules\SpecialChars;
use Illuminate\Http\Request;

class AdminCaptchaController extends Controller
{
    public function create()
    {
        return view('admincaptcha.create')->with('account', Account::select('user_id', 'role')->where('user_id', session('loggedUserId'))->first());
    }

    public function store()
    {
        request()->validate([
            'captcha_value' => ['required', new SpecialChars],
            'file' => ['required', 'mimetypes:image/svg,image/svg+xml'],
        ]);

        $filePath = request()->file('file')->storeAs(
            'public/captcha',
            Helper::renameFile('public/captcha', request()->file('file')->getClientOriginalName())
        );

        return $filePath;
    }
}
