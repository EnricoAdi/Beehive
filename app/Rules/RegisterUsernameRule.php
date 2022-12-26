<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class RegisterUsernameRule implements Rule
{
    // ENRICO - 220180499
    // ini untuk rule register apakah username sudah ada atau blm
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
        $dFound = User::get()->where("EMAIL", $value);
        if (count($dFound) > 0) {
            //ada user dengan record itu
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
        return 'Email ini sudah ada yang pakai';
    }
}
