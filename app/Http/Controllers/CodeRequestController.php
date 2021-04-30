<?php

namespace App\Http\Controllers;

use App\Http\Requests\CodeRequestDestroyRequest;
use App\Http\Requests\CodeRequestIndexRequest;
use App\Http\Requests\CodeRequestStoreRequest;
use App\Models\Account;
use App\Models\CodeRequest;
use App\Models\User;
use App\Services\CodeRequestService;

class CodeRequestController extends Controller
{

    public function index(CodeRequestIndexRequest $request)
    {
        return view('coderequests.index')
            ->with('account', Account::select('user_id', 'role')->where('user_id', auth()->user()->user_id)->first())
            ->with('coderequests', CodeRequestService::indexGetCodeRequests($request));
    }

    public function show(CodeRequest $codeRequest)
    {
        return view('coderequests.show')
            ->with('account', Account::select('user_id', 'role')->where('user_id', auth()->user()->user_id)->first())
            ->with('user', User::select('user_id', 'firstname', 'middlename', 'lastname', 'phone_number', 'city', 'province', 'account_code')->where('user_id', $codeRequest->user_id)->first())
            ->with('coderequest', $codeRequest);
    }

    public function store(CodeRequest $codeRequest, CodeRequestStoreRequest $request)
    {
        CodeRequestService::createCodes($codeRequest);
        CodeRequest::destroy($codeRequest->id);

        return redirect()->route('coderequest.index')
            ->with('acceptMessage', 'You have successfully accepted a code request.');
    }

    public function destroy(CodeRequest $codeRequest, CodeRequestDestroyRequest $request)
    {
        CodeRequest::destroy($codeRequest->id);

        return redirect()->route('coderequest.index')
            ->with('declineMessage', 'You have successfully declined a code request.');
    }
}
