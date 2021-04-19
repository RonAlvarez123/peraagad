<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CashoutController extends Controller
{
    public function index()
    {
        $method = request()->input('method');

        switch ($method) {
            case 'gcash':
                return view('cashout.gcash');
                break;
            case 'bank transfer':

                break;
            case 'money remittance':

                break;
            default:

                break;
        }
    }
}
