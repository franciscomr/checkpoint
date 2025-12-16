<?php

namespace App\Modules\Auth\Application\Services;

use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cache;


class LoginThrottleService
{
    protected int $maxFailedAttempts = 5;
    protected int $temporaryBanSeconds = 200;

    public function __construct(private RateLimiter $limiter)
    {
    }

    public function getKey(Request $request): string
    {
        $loginIdentifier = env('LOGIN_IDENTIFIER', 'email');

        return $request->input($loginIdentifier) .'|'. $request->ip();
    }
    
    public function ensureIsNotLocked(Request $request) {
        $key = $this->getKey($request);
        if($this->limiter->tooManyAttempts($key,$this->maxFailedAttempts)){
            $seconds = $this->limiter->availableIn($key);

            throw ValidationException::withMessages([
                'email' => ["Too many login attempts. Try again in {$seconds} seconds."],
            ]);
        }
    }

    public function recordFailedAttempt(Request $request){
        $key = $this->getKey($request);
        $this->limiter->hit($key, $this->temporaryBanSeconds);
    }

    public function clear(Request $request): void {
        $key = $this->getKey($request);
        $this->limiter->clear($key);
    }



}