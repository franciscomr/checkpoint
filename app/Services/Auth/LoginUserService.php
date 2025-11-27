<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginUserService
{
    public function attempt(array $credentials, bool $remember): ?User
    {
        $identifier = config('auth.login_identifier', 'email');

        $user = User::where($identifier, $credentials[$identifier])->first();

        if (!$user) {
            return null;
        }

        if (!Auth::attempt($credentials, $remember)) {
            return null;
        }

        return $user;
    }
}
