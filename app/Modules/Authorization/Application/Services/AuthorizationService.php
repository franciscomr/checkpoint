<?php

namespace App\Modules\Authorization\Application\Services;

use App\Models\User;
use App\Modules\Company\Domain\Models\Company;
use Illuminate\Auth\Access\AuthorizationException;

class AuthorizationService
{
    public function authorizePermission(User $user, string $permission, ?Company $company = null): void 
    {
        if (! $user->hasPermission($permission, $company?->id)) {
            throw new AuthorizationException(
                'You are not authorized to perform this action.'
            );
        }
    }

    public function authorizeRole(User $user, string $role, ?Company $company = null): void
    {
        if (! $user->hasRole($role, $company?->id)) {
            throw new AuthorizationException(
                'You do not have the required role.'
            );
        }
    }

    public function authorizeCompanyAccess(User $user, Company $company): void 
    {
        if (! $user->companies()->where('companies.id', $company->id)->exists()) {
            throw new AuthorizationException(
                'You do not have access to this company.'
            );
        }
    }
}
