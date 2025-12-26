<?php

namespace App\Modules\Authorization\Domain\Policies;

use App\Models\User;
use App\Modules\Company\Domain\Models\Company;

class CompanyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([
            'super_admin',
            'company_owner',
            'company_admin'
        ]);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    public function view(User $user, Company $company): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        if ($user->hasAnyRole(['company_owner', 'company_admin'])) {
            return $user->companyId() === $company->id;
        }
        return false;
    }

    public function update(User $user, Company $company): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        if ($user->hasRole('company_owner')) {
            return $user->companyId() === $company->id;
        }
        return false;
    }

    public function delete(User $user, Company $company): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        if ($user->hasRole('company_owner')) {
            return $user->companyId() === $company->id;
        }
        return false;
    }
}
