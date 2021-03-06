<?php

namespace App\Rules;

use App\Helper;
use Illuminate\Contracts\Validation\Rule;

class NoSpecialCharsRule implements Rule
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
        foreach (Helper::getSpecialChars() as $specialchar) {
            if (stripos($value, $specialchar) !== false) {
                return false;
            }
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
        return 'You cannot include a special character.';
    }
}
