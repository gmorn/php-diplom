<?php

namespace App\Http\Requests;

use App\Rules\CheckPasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'number' => 'required|exists:users,number',
            'password' => ['required', new CheckPasswordRule(request('number'))],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Это поле обязательно для заполнения',
            'password_check' => 'Неверный пароль',
            'exists' => 'Пользователя с таким номером телефона нет',
        ];
    }
}
