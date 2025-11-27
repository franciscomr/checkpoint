<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\LoginThrottleService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;

class LoginController extends Controller
{


    public function create()
    {
        return Inertia::render('auth/Login');
    }

    public function store(LoginRequest $request, LoginThrottleService $service)
    {
        $identifierField = config('auth.login_identifier', 'email');
    $identifier = $request->input($identifierField);

    if (!Auth::attempt($request->only($identifierField, 'password'))) {
        $service->registerFailedAttempt($identifier);

        return back()->withErrors([
            $identifierField => "Credenciales incorrectas"
        ]);
    }

    // Login correcto
    $service->registerSuccess($identifier);

    return redirect()->intended('/dashboard');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
