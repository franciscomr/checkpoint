<?php

namespace App\Modules\Authorization\Domain\Traits;

use App\Modules\Authorization\Domain\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasRoles
{
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles')
            ->withPivot('company_id')
            ->withTimestamps();
    }


    /**
    * Roles del usuario para una empresa específica
    */
    public function rolesForCompany(?int $companyId)
    {
        return $this->roles()
            ->wherePivot('company_id', $companyId);
    }


    /**
    * Asignar rol a usuario (opcionalmente por empresa)
    */
    public function assignRole(Role|string $role, ?int $companyId = null): void
    {
        $roleId = $role instanceof Role
            ? $role->id
            : Role::where('slug', $role)->value('id');

        $this->roles()->syncWithoutDetaching([
            $roleId => ['company_id' => $companyId],
        ]);
    }


    /**
    * Verifica si el usuario tiene un rol
    */
    public function hasRole(string $slug, ?int $companyId = null): bool
    {
        return $this->roles()
            ->where('roles.slug', $slug)
            ->where(function ($q) use ($companyId) {
                $q->wherePivot('company_id', $companyId)
                ->orWherePivot('company_id', null); // rol global
            })
            ->exists();
    }
}
