<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class RecieptController extends Controller
{
    public function edit()
    {
        $recieptPartners = [
            'puregold',
            'ever',
            'ultramega',
            'sm supermarket',
            'meralco',
            'pldt',
            'converge',
            'primewater',
            'nawasa',
            'bayad center',
        ];
        return view('reciept.edit')->with('partners', $recieptPartners)
            ->with('account', Account::select('role')->where('user_id', auth()->user()->user_id)->first());
    }

    public function update()
    {
        return;
    }
}
