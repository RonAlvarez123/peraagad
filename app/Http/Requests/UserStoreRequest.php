<?php

namespace App\Http\Requests;

use App\Rules\CodeExistsAndUnusedRule;
use App\Rules\NoLettersRule;
use App\Rules\NoSpecialCharsRule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'firstname' => ['required', 'min:3', new NoSpecialCharsRule],
            'middlename' => ['required', 'min:3', new NoSpecialCharsRule],
            'lastname' => ['required', 'min:3', new NoSpecialCharsRule],
            'phone_number' => ['required', 'unique:users', 'min:11', 'max:11', 'starts_with:09', new NoSpecialCharsRule, new NoLettersRule],
            'city' => ['required', 'min:3', new NoSpecialCharsRule],
            'province' => ['required', 'min:3', new NoSpecialCharsRule],
            'account_code' => [
                'required',
                new CodeExistsAndUnusedRule,
            ],
            'password' => ['required', 'confirmed', 'min:6', new NoSpecialCharsRule],

            // 'role' => ['required', 'in:user,moderator,admin'], // UNCOMMENT WHEN CREATING AN ACCOUNT FOR ADMIN
        ];
    }
}
