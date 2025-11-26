<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use App\Services\Auth\LoginService;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
        public function __construct(
        protected LoginService $loginService
    ) {}

    public function create()
    {
        return Inertia::render('auth/Login');
    }

    public function store( LoginRequest $request) {
        
         // Buscar usuario y empleado únicamente una vez
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors([
                'email' => 'Estas credenciales no coinciden.',
            ]);
        }

        // Validaciones de negocio usando el servicio
        try {
            $this->loginService->validateUserAndEmployee($user);
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => $e->getMessage(),
            ]);
        }

        // Intento de login
        if (!Auth::attempt(
            $request->only('email', 'password'),
            $request->boolean('remember')
        )) {
            return back()->withErrors([
                'email' => 'Contraseña incorrecta.',
            ]);
        }

        // Sesión
        $request->session()->regenerate();

        return redirect()->intended('/home');
    }
}
