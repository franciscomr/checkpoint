<?php

use App\Modules\Assets\Models\AssetStatus;
use App\Modules\Shared\Actions\InitializeTenantAction;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class
);

it('creates default asset statuses', function () {

    $tenant = Tenant::factory()->create();

    app(InitializeTenantAction::class)
        ->execute($tenant);

    expect(
        AssetStatus::query()->count()
    )->toBe(4);

    expect(
        AssetStatus::query()
            ->where('slug', 'assigned')
            ->exists()
    )->toBeTrue();

    expect(
        AssetStatus::query()
            ->where('slug', 'maintenance')
            ->exists()
    )->toBeTrue();
});