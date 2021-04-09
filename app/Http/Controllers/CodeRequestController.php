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
        $user = User::find(session('loggedUserId'), ['id', 'user_id']);

        // $user = User::find(session('loggedUserId'))->with('account')->first();
        // return $user;
        return view('coderequests.index')
            ->with('account', $user->account)
            ->with('coderequests', CodeRequest::with('user')->get()); // <-------- WITH EAGER LOADING //
    }

    public function accept()
    {
        for ($i = 0; $i < request()->input('number_of_codes'); $i++) {
            $this->createCode(request()->input('user_id'));
        }

        $result = CodeRequest::destroy(request()->input('coderequest_id'));

        if ($result == true) {
            return redirect()->route('coderequest.index')->with('acceptMessage', 'You have successfully accepted a code request.');
        }
        return redirect()->route('coderequest.index')->with('errorMessage', 'Code Request Approval Failed');
    }

    public function decline()
    {
        $result = CodeRequest::destroy(request()->input('coderequest_id'));

        if ($result == true) {
            return redirect()->route('coderequest.index')->with('declineMessage', 'You have successfully declined a code request.');
        }
        return redirect()->route('coderequest.index')->with('errorMessage', 'Code Request Declination Failed');
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
