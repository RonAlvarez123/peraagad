<?php

namespace App\Http\Requests;

use App\Rules\MatchCurrentUserPasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class CodeRequestStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => ['required', new MatchCurrentUserPasswordRule],
            'user_id' => ['required'],
            'coderequest_id' => ['required'],
            'number_of_codes' => ['required'],
        ];
    }
}
