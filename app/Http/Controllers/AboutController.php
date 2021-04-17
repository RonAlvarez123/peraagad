<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        return view('about.index')
            ->with('account', Account::select('user_id', 'role')->where('user_id', auth()->user()->user_id)->first());
    }
}
