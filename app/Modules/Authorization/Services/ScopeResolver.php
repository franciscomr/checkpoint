<?php

namespace App\Modules\Authorization\Services;

use App\Models\User;
use App\Modules\Authorization\Enums\PermissionScope;
use Illuminate\Database\Eloquent\Builder;

class ScopeResolver
{
    public function apply(
        Builder $query,
        User $user,
        string $permission
    ): Builder {

        $scope = $user->permissionScope($permission);

        /*
         * El usuario no tiene el permiso.
         */
        if ($scope === null) {
            return $query->whereRaw('1 = 0');
        }

        return match ($scope) {

            PermissionScope::ALL => $query,

            PermissionScope::TENANT => $query->where(
                'tenant_id',
                $user->tenant_id
            ),

            PermissionScope::BRANCH => $this->applyBranchScope(
                $query,
                $user
            ),

            PermissionScope::DEPARTMENT => $this->applyDepartmentScope(
                $query,
                $user
            ),

            PermissionScope::OWN => $this->applyOwnScope(
                $query,
                $user
            ),
        };
    }

    protected function applyBranchScope(
        Builder $query,
        User $user
    ): Builder {

        if (! $user->employee?->branch_id) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where(
            'branch_id',
            $user->employee->branch_id
        );
    }

    protected function applyDepartmentScope(
        Builder $query,
        User $user
    ): Builder {

        if (! $user->employee?->department_id) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where(
            'department_id',
            $user->employee->department_id
        );
    }

    protected function applyOwnScope(
        Builder $query,
        User $user
    ): Builder {

        if (! $user->employee_id) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where(
            'employee_id',
            $user->employee_id
        );
    }
}