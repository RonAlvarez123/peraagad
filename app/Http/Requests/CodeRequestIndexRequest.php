<?php

namespace App\Http\Requests;

use App\Rules\NoSpecialCharsRule;
use Illuminate\Foundation\Http\FormRequest;

class CodeRequestIndexRequest extends FormRequest
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
            'category' => ['required_with:value', 'in:account_code,firstname,lastname'],
            'order' => ['required_with:value', 'in:new,old'],
            'value' => [new NoSpecialCharsRule],
        ];
    }
}
