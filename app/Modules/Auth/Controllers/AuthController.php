<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Application\Resources\AuthResource;
use App\Modules\Auth\DTO\LoginDTO;
use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\Auth\Services\LoginService;
use App\Modules\Auth\Services\LoginThrottleService;
use App\Modules\Shared\Application\Http\ApiResponse;
use App\Modules\Auth\Application\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
     public function __construct(
        protected LoginService $loginService,
        protected LoginThrottleService $throttleService,
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $this->throttleService->ensureIsNotRateLimited($request);

        $dto = LoginDTO::fromRequest($request);

        try {
            $user = $this->loginService->login($dto);

        } catch (\Throwable $e) {
            $this->throttleService->hit($request);
            throw $e;
        }

        $this->throttleService->clear($request);

        $token = $user
            ->createToken($dto->deviceName)
            ->plainTextToken;

        return ApiResponse::success(
            data: new AuthResource([
                'token' => $token,
                'user' => $user->load('roles'),
            ]),
            message: 'Login successful'
        );
    }
}
