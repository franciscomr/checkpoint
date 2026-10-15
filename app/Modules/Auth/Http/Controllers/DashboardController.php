<?php

namespace App\Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Shared\Services\TenantManager;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(
        private readonly TenantManager $tenantManager
    ) {}

    public function __invoke(Request $request): Response
    {
        $tenant = $this->tenantManager->getTenant();

        // Muestra de métricas preliminares del ciclo de vida (ITIL)
        $stats = [
            'total_assets' => 10,       // Próximamente: Asset::count()
            'in_use' => 8,             // Asset::where('status', 'in_use')->count()
            'maintenance' => 2,        // Asset::where('status', 'maintenance')->count()
            'pending_requests' => 0,   // AssetRequest::where('status', 'pending')->count()
            'total_users' => User::count(),
        ];

        return Inertia::render('Dashboard', [
            'tenant' => [
                'name' => $tenant->name,
                'domain' => $tenant->domain,
            ],
            'stats' => $stats,
        ]);
    }
}
