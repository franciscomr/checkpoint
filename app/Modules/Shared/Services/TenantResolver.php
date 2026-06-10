<?php

namespace App\Modules\Shared\Services;

use App\Modules\Shared\Models\Tenant;
use App\Modules\Shared\Exceptions\TenantNotFoundException;
class TenantResolver
{
    public function resolve(string $slug): Tenant
    {
        $tenant = Tenant::query()
        ->where('slug', $slug)
        ->first();

        if (!$tenant) {
            throw new TenantNotFoundException();
        }

        return $tenant;
    }
}
