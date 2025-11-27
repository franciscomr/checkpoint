<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use App\Services\Auth\LoginThrottleService;

class LoginThrottleMiddleware
{
    protected LoginThrottleService $service;

    public function __construct(LoginThrottleService $service)
    {
        $this->service = $service;
    }

    public function handle(Request $request, Closure $next)
    {
        // Acepta email o username
        $identifierField = config('auth.login_identifier', 'email');
        $identifier = $request->input($identifierField);

        if ($identifier && $this->service->isBlocked($identifier)) {
            return back()->withErrors([
                $identifierField => "Demasiados intentos fallidos. Intenta de nuevo en "
                    . $this->service->getRemainingPenalty($identifier)
                    . " segundos."
            ]);
        }

        return $next($request);
    }
}
