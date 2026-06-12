<?php

namespace App\Modules\Auth\Services;

use App\Models\User;
use App\Modules\Auth\Exceptions\AuthInvalidCredentialsException;
use App\Modules\Auth\Exceptions\AuthUserInactiveException;
use Illuminate\Support\Facades\Hash;
use App\Modules\Auth\DTO\LoginDTO;
use App\Modules\Auth\Exceptions\LoginException;

class LoginService
{
    public function login(LoginDTO $dto): User
    {
        $user = User::query()
            ->where('email', $dto->email)
            ->first();

        if (! $user) {
            throw new AuthInvalidCredentialsException();
        }

        if (! Hash::check(
            $dto->password,
            $user->password
        )) {
            throw new AuthInvalidCredentialsException();
        }

        if (! $user->isActive()) {
            throw new AuthUserInactiveException();
        }

        return $user;
    }
}
