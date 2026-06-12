<?php

namespace App\Modules\Auth\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use App\Modules\Auth\Exceptions\AuthTooManyAttemptsException;

class LoginThrottleService
{
    protected int $maxAttempts = 5;

    protected int $decaySeconds = 60;

    public function ensureIsNotRateLimited(Request $request): void 
    {
        $key = $this->throttleKey($request);

        if (! RateLimiter::tooManyAttempts(
                $key,
                $this->maxAttempts
            )
        ) {
            return;
        }

        $seconds = RateLimiter::availableIn($key);

        throw  new AuthTooManyAttemptsException(
            $seconds
        );
    }

    public function hit(Request $request): void 
    {
        RateLimiter::hit(
            $this->throttleKey($request),
            $this->decaySeconds
        );
    }

    public function clear(Request $request): void {

        RateLimiter::clear(
            $this->throttleKey($request)
        );
    }

    protected function throttleKey(Request $request): string 
    {
        return implode('|', [
            tenant_id(),
            strtolower(
                $request->input('email')
            ),
            $request->ip(),
        ]);
    }
}
