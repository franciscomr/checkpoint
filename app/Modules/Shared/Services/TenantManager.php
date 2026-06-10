<?php

namespace App\Modules\Shared\Services;
use App\Modules\Shared\Models\Tenant;
class TenantManager
{
    protected ?Tenant $currentTenant = null;

    public function setTenant(Tenant $tenant): void
    {
        $this->currentTenant = $tenant;
    }

    public function getTenant(): ?Tenant
    {
        return $this->currentTenant;
    }

    public function getTenantId(): ?string
    {
        return $this->currentTenant?->id;;
    }

        public function hasTenant(): bool
    {
        return $this->currentTenant !== null;
    }
}

// Registramos el singleton en App\Providers\AppServiceProvider