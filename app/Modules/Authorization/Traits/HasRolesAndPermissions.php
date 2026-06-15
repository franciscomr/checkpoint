<?php

namespace App\Modules\Authorization\Traits;

use App\Modules\Authorization\Enums\PermissionScope;
use App\Modules\Shared\Models\Permission;
use Illuminate\Database\Eloquent\Collection;
trait HasRolesAndPermissions
{
    public function hasRole(string $role): bool
    {
        $this->loadMissing('roles');

        return $this->roles
            ->contains('slug', $role);
    }

    public function hasAnyRole(array $roles): bool
    {
        $this->loadMissing('roles');

        return $this->roles
            ->whereIn('slug', $roles)
            ->isNotEmpty();
    }

    public function hasPermission(string $permission): bool
    {
        $this->loadMissing('roles.permissions');

        return $this->roles
            ->flatMap(fn ($role) => $role->permissions)
            ->pluck('slug')
            ->contains($permission);
    }

    public function hasAnyPermission(array $permissions): bool
    {
        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permissions) {
                $query->whereIn('slug', $permissions);
            })
            ->exists();
    }

    public function permissions(): Collection
    {
        return Permission::query()
            ->whereHas('roles.users', function ($query) {
                $query->where('users.id', $this->id);
            })
            ->get();
    }

    public function permissionSlugs(): array
    {
        $this->loadMissing('roles.permissions');

        return $this->roles
            ->flatMap(fn ($role) => $role->permissions)
            ->pluck('slug')
            ->unique()
            ->values()
            ->toArray();
    }

public function permissionScope(string $permission): ?PermissionScope
    {
        $this->loadMissing('roles.permissions');

        $scopes = [];

        foreach ($this->roles as $role) {

            $permissionModel = $role->permissions
                ->firstWhere('slug', $permission);

            if ($permissionModel) {

                $scopes[] = PermissionScope::from(
                    $permissionModel->pivot->scope
                );
            }
        }

        if (empty($scopes)) {
            return null;
        }

        return collect($scopes)
            ->sortBy(fn (PermissionScope $scope) => match ($scope) {
                PermissionScope::ALL => 1,
                PermissionScope::TENANT => 2,
                PermissionScope::BRANCH => 3,
                PermissionScope::DEPARTMENT => 4,
                PermissionScope::OWN => 5,
            })
            ->first();
    }
}
