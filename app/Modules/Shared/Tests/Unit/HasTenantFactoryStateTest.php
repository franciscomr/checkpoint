<?php

use App\Modules\Assets\Models\Asset;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class
);

it("validates that it belongs to the same tenant", function () {
    $tenant = Tenant::factory()->create();

    $asset = Asset::factory()
        ->forTenant($tenant)
        ->make();

    expect($asset->tenant_id)
        ->toBe($tenant->id);
});