<?php

namespace App\Http\Requests;

use App\Models\Remit;
use App\Rules\MatchCurrentUserPasswordRule;
use App\Rules\NoLettersRule;
use App\Rules\NoSpecialCharsRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RemitStoreRequest extends FormRequest
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
            'firstname' => ['required', new NoSpecialCharsRule],
            'middlename' => ['required', new NoSpecialCharsRule],
            'lastname' => ['required', new NoSpecialCharsRule],
            'phone_number' => ['required', 'min:11', 'max:11', 'starts_with:09', new NoSpecialCharsRule, new NoLettersRule],
            'municipality' => ['required', new NoSpecialCharsRule],
            'province' => ['required', new NoSpecialCharsRule],
            'address' => ['required', new NoSpecialCharsRule],
            'remittance_outlet' => ['required', new NoSpecialCharsRule, Rule::in(Remit::getOutlets())],
            'password' => ['required', new MatchCurrentUserPasswordRule],
        ];
    }
}
