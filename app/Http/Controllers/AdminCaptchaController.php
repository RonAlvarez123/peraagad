<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Http\Requests\AdminCaptchaStoreRequest;
use App\Models\Account;
use App\Models\Captcha;
use Illuminate\Http\Request;

class AdminCaptchaController extends Controller
{
    public function create()
    {
        return view('admincaptcha.create')
            ->with('account', Account::select('user_id', 'role')->where('user_id', auth()->user()->user_id)->first());
    }

    public function store(AdminCaptchaStoreRequest $request)
    {
        $request->file('file')->storeAs('public/captcha', $filePath = Helper::renameFile('/captcha', $request->file('file')->getClientOriginalName()));

        if (Captcha::create(['value' => $request->value, 'path' => $filePath])) {
            return redirect()->route('admincaptcha.create')
                ->with('status', 'Captcha added successfuly.');
        }

        return redirect()->route('admincaptcha.create')
            ->withErrors(['value' => 'Captcha addition failed.']);
    }
}
