<?php

namespace App\Modules\Authorization\Domain\Policies;

use App\Models\User;

class PositionTemplatePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    public function view(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    public function update(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    public function delete(User $user): bool
    {
        return $user->hasRole('super_admin');
    }
}
