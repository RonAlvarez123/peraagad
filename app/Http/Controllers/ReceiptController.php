<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReceiptController extends Controller
{
    public function edit()
    {
        $userId = auth()->user()->user_id;
        return view('receipt.edit')->with('partners', Receipt::getPartners())
            ->with('account', Account::select('user_id', 'money', 'direct', 'indirect', 'role')->where('user_id', $userId)->first())
            ->with('receipt', Receipt::select('user_id', 'updated_at')->where('user_id', $userId)->first());
    }

    public function update()
    {
        request()->validate([
            'file' => ['required', 'mimetypes:image/jpeg,image/png', 'max:1024'],
            'partner' => ['required', Rule::in(Receipt::getPartners())],
        ]);

        $account = Account::select('id', 'user_id', 'money')->where('user_id', auth()->user()->user_id)->first();

        if ($account) {
            if ($account->receipt->updateReceipt()) {
                $account->getMoney(Receipt::getRate());
                return redirect()->route('receipt.edit')
                    ->with('status', 'Receipt upload successful.');
            }
            return redirect()->route('receipt.edit');
            // ->withErrors(['partner' => 'You already uploaded. Please wait some time to upload again.']);
        }
        return redirect()->route('receipt.edit')
            ->withErrors(['partner' => 'Receipt upload failed.']);
    }
}
