<?php

namespace App\Modules\Authorization\Domain\Policies;

use App\Models\User;
use App\Modules\Company\Domain\Models\Branch;
use App\Modules\Company\Domain\Models\Employee;

class EmployeePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([
            'super_admin',
            'company_owner',
            'company_admin'
        ]);
    }

    public function create(User $user, int $companyId, int $branchId): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        if ($user->hasAnyRole(['company_owner', 'company_admin'])) {
            return $user->companyId() === $companyId;
        }
        if ($user->hasRole('branch_manager')) {
            $user->branchId() === $branchId;
        }
        return false;
    }

    public function view(User $user, Employee $employee): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }

        if ($user->hasAnyRole(['company_owner', 'company_admin'])) {
            return $user->companyId() === $employee->branch->company_id;
        }

        if ($user->hasRole('branch_manager')) {
            $user->branchId() === $employee->branch_id;
        }

        return false;
    }


    public function update(User $user, Employee $employee): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }

        if ($user->hasAnyRole(['company_owner', 'company_admin'])) {
            return $user->companyId() === $employee->branch->company_id;
        }

        if ($user->hasRole('branch_manager')) {
            $user->branchId() === $employee->branch_id;
        }

        return false;
    }


    public function delete(User $user, Employee $employee): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }

        if ($user->hasAnyRole(['company_owner', 'company_admin'])) {
            return $user->companyId() === $employee->branch->company_id;
        }

        if ($user->hasRole('branch_manager')) {
            $user->branchId() === $employee->branch_id;
        }

        return false;
    }
}
