<?php

namespace App\Modules\Shared\Middleware;

use App\Modules\Shared\Contracts\TenantResolverInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\Shared\Services\TenantResolver;
use App\Modules\Shared\Services\TenantManager;
use App\Modules\Shared\Exceptions\TenantHeaderMissingException;

class TenantMiddleware
{
    public function __construct(
    protected TenantResolverInterface $resolver,
    protected TenantManager $tenantManager,
) {}
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = $this->resolver->resolve();

        $this->tenantManager->setTenant($tenant);

        return $next($request);
    }
}
