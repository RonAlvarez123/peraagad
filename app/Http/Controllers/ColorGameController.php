<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\ColorGame;
use Illuminate\Http\Request;

class ColorGameController extends Controller
{
    public function edit()
    {
        $account = Account::select('user_id', 'role')->where('user_id', auth()->user()->user_id)
            ->with('colorGame:user_id,points,multiplier')
            ->first();
        return view('colorgame.edit')
            ->with('account', $account)
            ->with('rewards', ColorGame::getRewards());
    }

    public function update()
    {
    }
}
