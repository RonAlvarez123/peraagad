<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CodeRequestController extends Controller
{
    public function index()
    {
        $user = User::find(session('loggedUserId'));
        return view('coderequests.index')->with('account', $user->account);
    }
}
