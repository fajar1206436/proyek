<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Password implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        return strlen($value) >= 8; // Password harus minimal 8 karakter
    }

    public function message()
    {
        return 'The :attribute must be at least 8 characters.';
    }
}