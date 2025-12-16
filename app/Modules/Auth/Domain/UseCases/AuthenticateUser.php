<?php

namespace App\Modules\Auth\Domain\UseCases;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
class AuthenticateUser
{
    public function execute(array $credentials):User
    {
        if(!Auth::attempt($credentials)){
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => ['Unable to sign in.'],
            ]);
        }

        if ($user->employee && !$user->employee->is_active) {
        Auth::logout();
            throw ValidationException::withMessages([
                'email' => ['Unable to sign in.'],
            ]);
        }

        return $user;
    }
}
