<?php

namespace App\Modules\Shared\Services;

use App\Modules\Shared\Contracts\TenantResolverInterface;
use App\Modules\Shared\Exceptions\TenantException;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DomainTenantResolver implements TenantResolverInterface
{
    public function __construct(
        protected Request $request
    ) {}

    public function resolve(): ?Tenant
    {
        $host = $this->request->getHost();

        if (blank($host)) {
            throw TenantException::tenantHostMissing();
        }

        $centralDomains = (array) config('app.central_domains', []);

        if (in_array($host, config('app.central_domains', []), true)) {
            return null; // Dominio central reconocido
        }

        // Cacheamos únicamente la ID (string/int) en lugar del objeto Eloquent completo
        $tenantId = Cache::remember("tenant_id_domain:{$host}", now()->addMinutes(10), function () use ($host) {
            return Tenant::query()->where('domain', $host)->value('id');
        });

        if (! $tenantId) {
            throw TenantException::tenantNotFound($host);
        }

        // Obtenemos el modelo fresco por su Primary Key
        $tenant = Tenant::find($tenantId);

        if (! $tenant) {
            // Si el tenant fue eliminado de la BD pero el ID seguía en caché
            Cache::forget("tenant_id_domain:{$host}");
            throw TenantException::tenantNotFound($host);
        }

        if (! $tenant->isActive()) {
            throw TenantException::tenantSuspended();
        }

        return $tenant;
    }
}
