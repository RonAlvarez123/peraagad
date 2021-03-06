<?php

namespace App\Http\Requests;

use App\Rules\NoSpecialCharsRule;
use Illuminate\Foundation\Http\FormRequest;

class AdminCaptchaStoreRequest extends FormRequest
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
            'value' => ['required', 'min:6', new NoSpecialCharsRule],
            'file' => ['required', 'mimetypes:image/svg,image/svg+xml'],
        ];
    }
}
