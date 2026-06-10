<?php

use App\Modules\Shared\Models\Tenant;
use App\Modules\Shared\Services\TenantManager;

if (! function_exists('tenant')) {

    function tenant(): ?Tenant
    {
        return app(TenantManager::class)
            ->getTenant();
    }
}

if (! function_exists('tenant_id')) {

    function tenant_id(): ?string
    {
        return app(TenantManager::class)
            ->getTenantId();
    }
}


/*

En composer.json agregar
    "autoload": {
        "files": [
            "App/Modules/Shared/Support/TenantHelper.php"
        ]
    }

*/
