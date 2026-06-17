<?php

namespace App\Modules\Shared\Database\Factories\Concerns;

use App\Modules\Shared\Models\Tenant;

trait HasTenantFactoryState
{
    public function forTenant(Tenant|string $tenant): static
    {
        $tenantId = $tenant instanceof Tenant
            ? $tenant->id
            : $tenant;

        return $this->state(fn () => [
            'tenant_id' => $tenantId,
        ]);
    }
}