<?php

namespace App\Modules\Authorization\Domain\Policies;

use App\Models\User;
use App\Modules\Company\Domain\Models\CompanyDepartment;

class CompanyDepartmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([
            'super_admin',
            'company_owner',
            'company_admin'
        ]);
    }

    public function create(User $user, int $companyId): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        if ($user->hasAnyRole(['company_owner', 'company_admin'])) {
            return $user->companyId() === $companyId;
        }
        return false;
    }

    public function view(User $user, CompanyDepartment $companyDepartment): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        if ($user->hasAnyRole(['company_owner', 'company_admin'])) {
            return $user->companyId() === $companyDepartment->company_id;
        }
        return false;
    }

    public function update(User $user, CompanyDepartment $companyDepartment): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        if ($user->hasRole('company_owner')) {
            return $user->companyId() === $companyDepartment->company_id;
        }
        return false;
    }

    public function delete(User $user, CompanyDepartment $companyDepartment): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        if ($user->hasRole('company_owner')) {
            return $user->companyId() === $companyDepartment->company_id;
        }
        return false;
    }
}
