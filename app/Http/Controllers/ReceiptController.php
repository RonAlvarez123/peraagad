<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReceiptUpdateRequest;
use App\Models\Account;
use App\Models\Receipt;

class ReceiptController extends Controller
{
    public function edit()
    {
        $userId = auth()->user()->user_id;
        return view('receipt.edit')->with('categories', Receipt::getCategories())
            ->with('account', Account::select('user_id', 'money', 'direct', 'indirect', 'role')->where('user_id', $userId)->first())
            ->with('receipt', Receipt::select('user_id', 'updated_at')->where('user_id', $userId)->first());
    }

    public function update(ReceiptUpdateRequest $request)
    {
        $account = Account::select('id', 'user_id', 'money')->where('user_id', auth()->user()->user_id)->first();

        if ($account) {
            if ($account->receipt->updateReceipt()) {
                $account->getMoney(Receipt::getRate());
                return redirect()->route('receipt.edit')
                    ->with('status', 'Receipt upload successful.');
            }
            return redirect()->route('receipt.edit');
        }
        return redirect()->route('receipt.edit')
            ->withErrors(['category' => 'Receipt upload failed.']);
    }
}
