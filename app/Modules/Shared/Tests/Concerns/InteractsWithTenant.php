<?php

namespace App\Modules\Shared\Tests\Concerns;

use App\Modules\Shared\Models\Tenant;
use App\Modules\Shared\Services\TenantManager;

trait InteractsWithTenant
{
    protected function setCurrentTenant(Tenant $tenant): void
    {
        app(TenantManager::class)
            ->setTenant($tenant);
    }
}
