<?php

namespace App\Modules\Auth\Application\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticateUserService
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
                'email' => ['Unable to sign in isnotactive.'],
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
