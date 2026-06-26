<?php

use App\Modules\Assets\Models\AssetAssignment;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class,
);

it('assigns tenant correctly', function () {

    $tenant = Tenant::factory()->create();

    $assignment = AssetAssignment::factory()
        ->forTenant($tenant)
        ->make();

    expect($assignment->tenant_id)
        ->toBe($tenant->id);
});