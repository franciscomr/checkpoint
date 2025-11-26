<?php

namespace App\Services\Auth;

use App\Models\User;

class LoginService
{
    /**
     * Valida el estado del usuario y su empleado asociado.
     *
     * @throws \Exception
     */
    public function validateUserAndEmployee(User $user): void
    {
        /*
        if (!$user->is_active) {
            throw new \Exception('El usuario está inactivo.');
        }

        if (!$user->empleado) {
            throw new \Exception('No se encontró un empleado asignado.');
        }

        if (!$user->empleado->is_active) {
            throw new \Exception('El empleado asignado está inactivo.');
        }
            */
    }
}
