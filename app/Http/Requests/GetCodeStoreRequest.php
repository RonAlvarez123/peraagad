<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetCodeStoreRequest extends FormRequest
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
            'number_of_codes' => ['required', 'numeric', 'gte:1', 'lte:9'],
            'password' => ['required']
        ];
    }
}
