<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Http\Requests\CodeRequestStoreRequest;
use App\Models\Account;
use App\Models\Code;
use App\Models\CodeRequest;
use App\Models\User;
use Illuminate\Http\Request;

class CodeRequestController extends Controller
{
    // private int $myCounter = 0;
    // private int $errorCount = 0;

    public function index()
    {
        return view('coderequests.index')
            ->with('account', Account::select('user_id', 'role')->where('user_id', auth()->user()->user_id)->first())
            ->with('coderequests', CodeRequest::select('id', 'user_id', 'number_of_codes', 'requested_at')
                ->with([
                    'user' => function ($query) {
                        $query->select('user_id', 'firstname', 'lastname', 'account_code');
                    }
                ])->latest('requested_at')->get()); // <-------- WITH EAGER LOADING //
    }

    public function show(CodeRequest $codeRequest)
    {
        // return $codeRequest;
        return view('coderequests.show')
            ->with('account', Account::select('user_id', 'role')->where('user_id', auth()->user()->user_id)->first())
            ->with('user', User::select('user_id', 'firstname', 'middlename', 'lastname', 'phone_number', 'city', 'province', 'account_code')->where('user_id', $codeRequest->user_id)->first())
            ->with('coderequest', $codeRequest);
    }

    public function store(CodeRequestStoreRequest $request)
    {
        for ($i = 0; $i < $request->number_of_codes; $i++) {
            $this->createCode($request->user_id);
        }

        if (CodeRequest::destroy($request->coderequest_id)) {
            return redirect()->route('coderequest.index')
                ->with('acceptMessage', 'You have successfully accepted a code request.');
        }
        return redirect()->route('coderequest.index')
            ->with('errorMessage', 'Code Request Approval Failed');
    }

    public function destroy(CodeRequestStoreRequest $request)
    {
        if (CodeRequest::destroy($request->coderequest_id)) {
            return redirect()->route('coderequest.index')
                ->with('declineMessage', 'You have successfully declined a code request.');
        }
        return redirect()->route('coderequest.index')
            ->with('errorMessage', 'Code Request Declination Failed');
    }

    public function createCode($userId)
    {
        $counter = 0;
        $repetitionLimit = 20;
        do {
            if ($counter >= $repetitionLimit) {
                return false;
            }
            $code = Helper::randomString(11, $userId);
            $existingCode = Code::select('id', 'user_id', 'account_code')->where([
                'account_code' => $code,
                'used' => false,
            ])->first();
            $counter++;
        } while ($existingCode);

        return Code::create([
            'user_id' => $userId,
            'account_code' => $code,
        ]);
    }
}
