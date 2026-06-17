<?php

namespace App\Modules\Shared\Actions;

use App\Modules\Shared\Database\Seeders\AssetCategorySeeder;
use App\Modules\Shared\Database\Seeders\AssetStatusSeeder;
use App\Modules\Shared\Models\Tenant;

class InitializeTenantAction
{
    public function execute(Tenant $tenant): void
    {
        app(AssetStatusSeeder::class)
            ->run($tenant);

        app(AssetCategorySeeder::class)
            ->run($tenant);
    }
}
