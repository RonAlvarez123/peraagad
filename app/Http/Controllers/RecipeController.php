<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function edit()
    {
        return view('recipe.edit')
            ->with('account', Account::select('user_id', 'money', 'direct', 'indirect', 'role')->where('user_id', auth()->user()->user_id)->first());
    }

    public function update()
    {
    }
}
