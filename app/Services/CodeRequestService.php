<?php

namespace App\Services;

use App\Helper;
use App\Http\Requests\CodeRequestIndexRequest;
use App\Models\Code;
use App\Models\CodeRequest;

class CodeRequestService
{
    public static function indexGetCodeRequests(CodeRequestIndexRequest $request)
    {
        if ($request->value) {
            $coderequests = CodeRequest::with([
                'user' => function ($query) {
                    $query->select('user_id', 'firstname', 'lastname', 'account_code')->where(request()->input('category'), 'like', '%' . request()->input('value') . '%');
                }
            ])->get()
                ->filter(fn ($coderequest) => $coderequest->user !== null);
            $coderequests = ($request->order === 'old') ? $coderequests->sortBy('requested_at') : $coderequests->sortByDesc('requested_at');
            return $coderequests;
        }

        return CodeRequest::with([
            'user' => function ($query) {
                $query->select('user_id', 'firstname', 'lastname', 'account_code');
            }
        ])->latest('requested_at')->get();
    }

    public static function createCodes(CodeRequest $codeRequest)
    {
        for ($i = 0; $i < $codeRequest->number_of_codes; $i++) {
            self::generateCode($codeRequest->user_id);
        }
    }

    private static function generateCode($id)
    {
        $counter = 0;
        $repetitionLimit = 20;
        do {
            if ($counter >= $repetitionLimit) {
                return false;
            }
            $code = Helper::randomString(11, $id);
            $existingCode = Code::select('id', 'user_id', 'account_code')->where([
                'account_code' => $code,
                'used' => false,
            ])->first();
            $counter++;
        } while ($existingCode);

        return Code::create([
            'user_id' => $id,
            'account_code' => $code,
        ]);
    }
}
