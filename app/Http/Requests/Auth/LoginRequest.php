<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
         $identifier = config('auth.login_identifier', 'email');

         if ($identifier === 'email'){
            $rules = ['required', 'email'];
         } else {
            $rules = ['required', 'string'];
         }

        return [
            $identifier => $rules,
            'password' => ['required'],
            'remember' => ['nullable', 'boolean'],
        ];
    }
}
