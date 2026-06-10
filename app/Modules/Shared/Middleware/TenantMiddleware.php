<?php

namespace App\Modules\Shared\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\Shared\Services\TenantResolver;
use App\Modules\Shared\Services\TenantManager;
use App\Modules\Shared\Exceptions\TenantHeaderMissingException;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenantSlug = $request->header('X-Tenant-ID');

        if (blank($tenantSlug)) {
            throw new TenantHeaderMissingException();
        }
        
        $tenant = app(TenantResolver::class)
            ->resolve($tenantSlug);

        app(TenantManager::class)
            ->setTenant($tenant);

        return $next($request);
    }
}
