<?php

namespace App\Http\Requests;

use App\Rules\SpecialChars;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'firstname' => ['required', 'min:3', new SpecialChars],
            'middlename' => ['required', 'min:3', new SpecialChars],
            'lastname' => ['required', 'min:3', new SpecialChars],
            'phone_number' => ['required', 'unique:users', 'min:11', 'max:11', 'starts_with:09'],
            'city' => ['required', 'min:3', new SpecialChars],
            'province' => ['required', 'min:3', new SpecialChars],
            'account_code' => ['required', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:6'],

            // 'role' => ['required', 'in:user,moderator,admin'], // UNCOMMENT WHEN CREATING AN ACCOUNT FOR ADMIN
        ];
    }
}
