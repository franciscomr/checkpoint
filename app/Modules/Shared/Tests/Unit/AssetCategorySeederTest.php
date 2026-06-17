<?php

use App\Modules\Assets\Models\AssetCategory;
use App\Modules\Shared\Actions\InitializeTenantAction;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class
);

it('creates default asset categories', function () {

    $tenant = Tenant::factory()->create();

    app(InitializeTenantAction::class)
        ->execute($tenant);

    expect(
        AssetCategory::query()->count()
    )->toBe(5);

    expect(
        AssetCategory::query()
            ->where('slug', 'hardware')
            ->exists()
    )->toBeTrue();

    expect(
        AssetCategory::query()
            ->where('slug', 'software')
            ->exists()
    )->toBeTrue();
});