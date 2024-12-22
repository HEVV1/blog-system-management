<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $routeName = $this->route()->getName();

        return match ($routeName) {
            'register' => [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ],
            'login' => [
                'email' => 'required|email',
                'password' => 'required',
            ],
            default => [],
        };
    }

    public function messages(): array
    {
        $routeName = $this->route()->getName();

        return match ($routeName) {
            'register' => [
                'name.required' => 'The name field can not be empty',
                'email.unique' => 'This email has already been taken',
                'password.confirmed' => 'Passwords do not match',
            ],
            'login' => [
                'email.required' => 'Email field can\'t be empty',
                'password.required' => 'Passwords field can\'t be empty',
            ],
            default => [],
        };
    }
}
