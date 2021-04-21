<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CashoutRequestController extends Controller
{
    public function redirect()
    {
        $method = request()->input('method');
        switch ($method) {
            case 'gcash':
                return redirect()->route('gcash.create');
                break;
            case 'bank':
                return redirect()->route('bank.create');
                break;
            case 'remit':
                return redirect()->route('remit.create');
                break;
            default:

                break;
        }
    }
}
