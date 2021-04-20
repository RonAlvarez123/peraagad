<?php

namespace App\Http\Requests;

use App\Rules\SpecialChars;
use Illuminate\Foundation\Http\FormRequest;

class RemitRequest extends FormRequest
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
            'firstname' => ['required', new SpecialChars],
            'middlename' => ['required', new SpecialChars],
            'lastname' => ['required', new SpecialChars],
            'phone_number' => ['required', new SpecialChars],
            'municipality' => ['required', new SpecialChars],
            'province' => ['required', new SpecialChars],
            'address' => [new SpecialChars],
        ];
    }
}
