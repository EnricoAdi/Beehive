<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class LoginPasswordRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $email = "";
    public function __construct($email)
    {
        $this->email = $email;
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
        $dFound = User::get()->where("EMAIL", $this->email);
        if(count($dFound) > 0){
            $dFound = $dFound->first();
            if(Hash::check($value, $dFound->PASSWORD)){
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Password tidak sesuai';
    }
}
