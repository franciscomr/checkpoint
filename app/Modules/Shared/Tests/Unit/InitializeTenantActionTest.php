<?php

use App\Modules\Assets\Models\AssetCategory;
use App\Modules\Assets\Models\AssetStatus;
use App\Modules\Shared\Actions\InitializeTenantAction;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class
);

it('creates independent catalogs for each tenant', function () {

    $tenantA = Tenant::factory()->create();

    $tenantB = Tenant::factory()->create();

    app(InitializeTenantAction::class)
        ->execute($tenantA);

    app(InitializeTenantAction::class)
        ->execute($tenantB);

    expect(
        AssetStatus::withoutGlobalScopes()->count()
    )->toBe(8);

    expect(
        AssetCategory::withoutGlobalScopes()->count()
    )->toBe(10);
});