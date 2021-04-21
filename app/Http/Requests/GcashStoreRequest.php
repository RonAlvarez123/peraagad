<?php

namespace App\Http\Requests;

use App\Rules\NoLettersRule;
use App\Rules\NoSpecialCharsRule;
use Illuminate\Foundation\Http\FormRequest;

class GcashStoreRequest extends FormRequest
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
            'account_name' => ['required', new NoSpecialCharsRule],
            'account_number' => ['required', 'min:11', 'max:11', 'starts_with:09', new NoSpecialCharsRule, new NoLettersRule],
        ];
    }
}
