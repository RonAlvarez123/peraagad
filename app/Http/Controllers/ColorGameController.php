<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\ColorGame;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ColorGameController extends Controller
{
    public function edit()
    {
        $account = Account::select('user_id', 'role')->where('user_id', auth()->user()->user_id)
            ->with('colorGame:user_id,points,multiplier,updated_at')
            ->first();
        return view('colorgame.edit')
            ->with('account', $account)
            ->with('rewards', ColorGame::getRewards());
    }

    public function update()
    {
        $colorGame = ColorGame::select('id', 'user_id', 'points', 'multiplier', 'number_of_times_played', 'updated_at')->where('user_id', auth()->user()->user_id)->first();
        if ($colorGame->play()) {
            return redirect()->route('colorgame.edit')
                ->with('status', $colorGame->getPlayResult());
        }
        return redirect()->route('colorgame.edit');
    }

    public function claim()
    {
        request()->validate([
            'reward' => ['required', Rule::in(ColorGame::getRewardIds())],
        ]);

        $account = Account::select('id', 'user_id', 'money')->where('user_id', auth()->user()->user_id)
            ->with('colorGame:id,user_id,points,multiplier,updated_at')
            ->first();
        $rewards = ColorGame::getRewards();
        foreach ($rewards as $reward) {
            if ($reward['id'] == request()->input('reward') && $account->colorGame->points >= $reward['points']) {
                $account->getMoney($reward['money']);
                $account->colorGame->reducePoints($reward['points']);
                $points = number_format($reward['points']);
                $money = number_format($reward['money']);

                return redirect()->route('colorgame.edit')
                    ->with('status', "You have exchanged your {$points} points for {$money} Pesos.");
            }
        }
        return redirect()->route('colorgame.edit')
            ->withErrors(['reward' => 'You dont have enough points to claim that reward.']);
    }
}
