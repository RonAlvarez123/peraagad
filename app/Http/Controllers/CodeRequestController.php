<?php

namespace App\Http\Controllers;

use App\Helper;
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
        // $coderequest = CodeRequest::find(1);
        // return $coderequest->user;
        $user = User::find(session('loggedUserId'));
        return view('coderequests.index')->with('account', $user->account)->with('coderequests', CodeRequest::all());
    }

    public function accept()
    {
        // return  request()->input('user_id') . ' ' . request()->input('number_of_codes') . 'accepted' . request()->input('coderequest_id');
        // $numberOfCodes = request()->input('number_of_codes');
        // $userId = request()->input('user_id');
        // $codeRequestId = request()->input('coderequest_id');

        for ($i = 0; $i < request()->input('number_of_codes'); $i++) {
            $this->createCode(request()->input('user_id'));
        }

        CodeRequest::where('id', request()->input('coderequest_id'))->delete();

        return view('coderequests.index');
    }

    public function decline()
    {
        return 'declined' . request()->input('coderequest_id');
    }

    public function createCode($userId)
    {
        try {
            // $this->myCounter++;
            return Code::create([
                'user_id' => $userId,
                'account_code' => Helper::randomString(11, $userId)
            ]);
        } catch (\Illuminate\Database\QueryException $exception) {
            // $this->errorCount++;
            return $this->createCode($userId);
        }
    }
}
