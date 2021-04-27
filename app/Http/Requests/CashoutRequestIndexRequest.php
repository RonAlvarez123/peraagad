<?php

namespace App\Http\Requests;

use App\Rules\NoSpecialCharsRule;
use Illuminate\Foundation\Http\FormRequest;

class CashoutRequestIndexRequest extends FormRequest
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
            'type' => ['required_with:order', 'in:gcash,bank,remit', new NoSpecialCharsRule],
            'order' => ['required_with:type', 'in:new,old', new NoSpecialCharsRule],
        ];
    }
}
