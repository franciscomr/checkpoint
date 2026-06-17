<?php

use App\Modules\Assets\Actions\CreateAssetAction;
use App\Modules\Assets\DTO\CreateAssetDTO;
use App\Modules\Assets\Exceptions\AssetCreationException;
use App\Modules\Assets\Models\AssetCategory;
use App\Modules\Assets\Models\AssetStatus;
use App\Modules\Shared\Models\Tenant;
use App\Modules\Shared\Services\TenantManager;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class
);

it('throws exception when category does not exist', function () {

    $tenant = Tenant::factory()->create();

    app(TenantManager::class)
        ->setTenant($tenant);

    $status = AssetStatus::factory()
        ->forTenant($tenant)
        ->create();

    $dto = new CreateAssetDTO(
        name: 'MacBook Pro',
        assetCategoryId: 999999,
        assetStatusId: $status->id,
    );

    try {

        app(CreateAssetAction::class)
            ->execute($dto);

        $this->fail();

    } catch (AssetCreationException $e) {

        expect($e->getErrorCode())
            ->toBe('ASSET_CATEGORY_NOT_FOUND');
    }
});


it('throws exception when status does not exist', function () {

    $tenant = Tenant::factory()->create();

    app(TenantManager::class)
        ->setTenant($tenant);

    $category = AssetCategory::factory()
        ->forTenant($tenant)
        ->create();

    $dto = new CreateAssetDTO(
        name: 'MacBook Pro',
        assetCategoryId: $category->id,
        assetStatusId: 999999,
    );

    try {

        app(CreateAssetAction::class)
            ->execute($dto);

        $this->fail();

    } catch (AssetCreationException $e) {

        expect($e->getErrorCode())
            ->toBe('ASSET_STATUS_NOT_FOUND');
    }
});

it('generates asset tag automatically', function () {

    $tenant = Tenant::factory()->create();

    app(TenantManager::class)
        ->setTenant($tenant);

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

    expect($asset->asset_tag)
        ->not
        ->toBeNull();

    expect($asset->asset_tag)
        ->not
        ->toBe('');
});

it('uses provided asset tag', function () {

    $tenant = Tenant::factory()->create();

    app(TenantManager::class)
        ->setTenant($tenant);

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
        assetTag: 'AST-000001'
    );

    $asset = app(CreateAssetAction::class)
        ->execute($dto);

    expect($asset->asset_tag)
        ->toBe('AST-000001');
});

it('throws exception when supplier does not exist', function () {

    $tenant = Tenant::factory()->create();

    app(TenantManager::class)
        ->setTenant($tenant);

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
        supplierId: 999999,
    );

    expect(
        fn () => app(CreateAssetAction::class)
            ->execute($dto)
    )->toThrow(AssetCreationException::class);
});

it('loads relationships after creation', function () {

    $tenant = Tenant::factory()->create();

    app(TenantManager::class)
        ->setTenant($tenant);

    $category = AssetCategory::factory()
        ->forTenant($tenant)
        ->create();

    $status = AssetStatus::factory()
        ->forTenant($tenant)
        ->create();

    $asset = app(CreateAssetAction::class)
        ->execute(
            new CreateAssetDTO(
                name: 'MacBook Pro',
                assetCategoryId: $category->id,
                assetStatusId: $status->id,
            )
        );

    expect($asset->relationLoaded('category'))
        ->toBeTrue();

    expect($asset->relationLoaded('status'))
        ->toBeTrue();
});