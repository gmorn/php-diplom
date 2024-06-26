<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegRequest extends FormRequest
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
            'number' => 'required|unique:users',
            'name' => 'required',
            'password' => 'required|min:6',
            'password_repeat' => 'required|same:password',
        ];
    }
    public function messages(): array
    {
        return [
            'required' => 'Это поле обязательно для заполнения',
            'min' => 'Длина пароля минимум 6 символов',
            'unique' => 'Номер уже занят другим пользователем',
            'same' => 'Пароли не совпадают',
        ];
    }
}
