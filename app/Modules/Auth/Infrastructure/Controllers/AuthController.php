<?php

namespace App\Modules\Auth\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Application\Request\LoginRequest;
use App\Modules\Auth\Application\Resources\LoginResource;
use App\Modules\Auth\Application\Services\LoginThrottleService;
use App\Modules\Auth\Application\Services\SessionAuditService;
use App\Modules\Auth\Domain\UseCases\AuthenticateUser;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function __construct(
        private AuthenticateUser $authenticateUser,
        private LoginThrottleService $throttle,
        private SessionAuditService $sessionAudit)
    {
    }

    public function login(LoginRequest $request)
    {
        $this->throttle->ensureIsNotLocked($request);

        try {
            $user = $this->authenticateUser->execute($request->validated());
        } catch (\Throwable $e) {
            $this->throttle->recordFailedAttempt($request);
        throw $e;
        }

        $this->throttle->clear($request);
        $request->session()->regenerate();
        $this->sessionAudit->register($request);

        return new LoginResource($user);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->sessionAudit->close($request);
        Auth::logout();

        $request->session()->invalidate();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'data' => $request->user(),
        ]);
    }
}
