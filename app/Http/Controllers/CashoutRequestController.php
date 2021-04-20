<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Account;
use App\Rules\SpecialChars;
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

                break;
            case 'remit':

                break;
            default:

                break;
        }
    }

    public function bank()
    {
    }

    public function remit()
    {
    }

    public function summary()
    {
        return view('cashoutrequests.summary');
    }

    public function store()
    {
        $method = request()->input('method');

        switch ($method) {
            case 'gcash':
                break;
            case 'bank':
                request()->validate([
                    'account_name' => ['required', new SpecialChars],
                    'account_number' => ['required', new SpecialChars],
                    'bank_name' => ['required', new SpecialChars],
                ]);
                break;
            case 'remit':
                request()->validate([
                    'firstname' => ['required', new SpecialChars],
                    'middlename' => ['required', new SpecialChars],
                    'lastname' => ['required', new SpecialChars],
                    'phone_number' => ['required', new SpecialChars],
                    'municipality' => ['required', new SpecialChars],
                    'province' => ['required', new SpecialChars],
                    'address' => [new SpecialChars],
                ]);
                break;
            default:
                return $method;
                break;
        }
    }
}
