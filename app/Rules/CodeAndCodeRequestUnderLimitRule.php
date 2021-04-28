<?php

namespace App\Rules;

use App\Models\Account;
use Illuminate\Contracts\Validation\Rule;

class CodeAndCodeRequestUnderLimitRule implements Rule
{
    private $codesAndRequestsTotal = 0;
    private $validRequests = 0;

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
        $account = Account::where('user_id', auth()->user()->user_id)->first();

        $this->codesAndRequestsTotal =  $account->totalCodeRequests() + $account->totalCodes();

        if ($this->codesAndRequestsTotal + $value > 9) {
            $this->validRequests = 9 - $this->codesAndRequestsTotal;
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
        if ($this->validRequests > 0) {
            return "You will be reaching your Code and Code Request Limit. You can only request {$this->validRequests} codes or you can comeback later to request a code after you sell some of your codes.";
        }
        return 'You have reached your Code and Code Request Limit. Please comeback later to request a code after you sell some of your codes.';
    }
}
