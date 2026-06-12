<?php

namespace App\Modules\Shared\Services;

use App\Modules\Shared\Contracts\TenantResolverInterface;
use App\Modules\Shared\Exceptions\TenantHeaderMissingException;
use App\Modules\Shared\Exceptions\TenantNotFoundException;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Http\Request;
class HeaderTenantResolver implements TenantResolverInterface
{
    public function __construct(
        protected Request $request
    ) {}

    public function resolve(): Tenant
    {
        $tenantId = $this->request->header('X-Tenant-ID');

        if (! $tenantId) {
            throw new TenantHeaderMissingException();
        }

        $tenant = Tenant::query()
            ->find($tenantId);

        if (! $tenant) {
            throw new TenantNotFoundException();
        }

        return $tenant;
    }
}
