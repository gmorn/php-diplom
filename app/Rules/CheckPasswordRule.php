<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class CheckPasswordRule implements ValidationRule
{
    protected $number;

    public function __construct($number)
    {
        $this->number = $number;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  Closure  $fail
     * @return void
     */
    public function validate(string $attribute, $value, Closure $fail): void
    {
        $user = DB::table('users')->where('number', $this->number)->first();

        if (!$user) {
            return;
        }

        if (!password_verify($value, $user->password)) {
            $fail('Неверный пароль');
        }
    }
}
