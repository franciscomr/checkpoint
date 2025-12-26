<?php

namespace App\Modules\Authorization\Domain\Policies;

use App\Models\User;
use App\Modules\Company\Domain\Models\CompanyDepartment;

class CompanyDepartmentPolicy
{
    public function view(User $user, CompanyDepartment $department): bool
    {
        return $user->hasPermission('department.view', $department->company_id);
    }


    public function create(User $user, int $companyId): bool
    {
        return $user->hasPermission('department.create', $companyId);
    }


    public function update(User $user, CompanyDepartment $department): bool
    {
        return $user->hasPermission('department.update', $department->company_id);
    }


    public function delete(User $user, CompanyDepartment $department): bool
    {
        return $user->hasPermission('department.delete', $department->company_id);
    }
}
