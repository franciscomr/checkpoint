<?php

use App\Modules\Assets\Actions\CreateAssetAction;
use App\Modules\Assets\DTO\CreateAssetDTO;
use App\Modules\Assets\Models\AssetCategory;
use App\Modules\Assets\Models\AssetStatus;
use App\Modules\Shared\Models\Tenant;
use App\Modules\Shared\Tests\Concerns\InteractsWithTenant;
use Illuminate\Foundation\Testing\RefreshDatabase;


uses(
    Tests\TestCase::class,
    RefreshDatabase::class,
    InteractsWithTenant::class
);


it('creates an asset', function () {

    $tenant = Tenant::factory()->create();

$this->setCurrentTenant($tenant);


    $category = AssetCategory::factory()
        ->forTenant($tenant)
        ->create();

    $status = AssetStatus::factory()
        ->forTenant($tenant)
        ->create();

    $dto = new CreateAssetDTO(
        name: 'MacBook Pro',
        assetCategoryId: $category->id,
        assetStatusId: $status->id,
    );

    $asset = app(CreateAssetAction::class)
        ->execute($dto);

    expect($asset->exists)->toBeTrue();

    expect($asset->name)
        ->toBe('MacBook Pro');
});