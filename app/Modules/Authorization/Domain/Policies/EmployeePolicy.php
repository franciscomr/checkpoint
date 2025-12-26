<?php

namespace App\Modules\Authorization\Domain\Policies;

use App\Models\User;
use App\Modules\Company\Domain\Models\Employee;

class EmployeePolicy
{
public function view(User $user, Employee $employee): bool
{
    return $user->hasPermission('employee.view', $employee->company_id);
}


public function create(User $user, int $companyId): bool
{
    return $user->hasPermission('employee.create', $companyId);
}


public function update(User $user, Employee $employee): bool
{
    return $user->hasPermission('employee.update', $employee->company_id);
}


public function delete(User $user, Employee $employee): bool
{
    return $user->hasPermission('employee.delete', $employee->company_id);
}
}
