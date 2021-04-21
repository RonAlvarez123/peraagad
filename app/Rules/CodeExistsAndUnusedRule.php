<?php

namespace App\Rules;

use App\Models\Code;
use Illuminate\Contracts\Validation\Rule;

class CodeExistsAndUnusedRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!Code::where(['account_code' => $value, 'used' => false])->first()) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You have entered an invalid code.';
    }
}
