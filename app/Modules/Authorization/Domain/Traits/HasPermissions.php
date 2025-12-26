<?php

namespace App\Modules\Authorization\Domain\Traits;

use Illuminate\Support\Facades\Cache;

trait HasPermissions
{
    /**
    * Verifica permiso (company-aware)
    */
    public function hasPermission(string $permission, ?int $companyId = null): bool
    {
        return Cache::remember(
            "permissions:{$this->id}:{$companyId}",
            now()->addMinutes(5),
            fn () => $this->resolvePermissions($companyId)
        )->contains($permission);
    }


    protected function resolvePermissions(?int $companyId)
    {
        return $this->roles()
            ->where(function ($q) use ($companyId) {
                $q->wherePivot('company_id', $companyId)
                ->orWherePivot('company_id', null);
            })
            ->with('permissions:slug')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('slug')
            ->unique();
    }
}
