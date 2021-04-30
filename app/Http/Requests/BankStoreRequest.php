<?php

namespace App\Http\Requests;

use App\Models\Bank;
use App\Rules\MatchCurrentUserPasswordRule;
use App\Rules\NoLettersRule;
use App\Rules\NoSpecialCharsRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BankStoreRequest extends FormRequest
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
            'account_number' => ['required', 'min:5', 'max:15', new NoSpecialCharsRule, new NoLettersRule],
            'bank_partner' => ['required', new NoSpecialCharsRule, Rule::in(Bank::getPartners())],
            'password' => ['required', new MatchCurrentUserPasswordRule],
        ];
    }
}
