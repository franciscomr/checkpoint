<?php

namespace App\Modules\Auth\DTO;

use App\Modules\Auth\Requests\LoginRequest;

class LoginDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly bool $remember = false,
        public readonly string $deviceName = 'web',
    ) {}

    public static function fromRequest(LoginRequest $request): self
    {
        return new self(
            email: $request->string('email')->toString(),
            password: $request->string('password')->toString(),
            remember: $request->boolean('remember'),
            deviceName: $request->input('deviceName', 'web'),
        );
    }
}
