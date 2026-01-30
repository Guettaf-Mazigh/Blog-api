<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:3', 'max:25'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name is required',
            'name.min' => 'The name must be at least :min characters',
            'email.required' => 'The email is required',
            'password.required' => 'The password is required',
            'password.min' => 'The password must be at least :min characters',
            'password.confirmed' => 'The password confirmation does not match',
        ];
    }
}
