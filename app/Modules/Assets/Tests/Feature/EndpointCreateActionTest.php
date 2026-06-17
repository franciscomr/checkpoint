<?php

use App\Models\User;
use App\Modules\Assets\Models\AssetCategory;
use App\Modules\Assets\Models\AssetStatus;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class
);

it('can create asset', function () {

    $tenant = Tenant::factory()->create();

    $user = User::factory()
        ->forTenant($tenant)
        ->create();

    $category = AssetCategory::factory()
        ->forTenant($tenant)
        ->create();

    $status = AssetStatus::factory()
        ->forTenant($tenant)
        ->create();

    $response = $this
        ->actingAs($user)
        ->withHeader(
            'X-Tenant-ID',
            $tenant->id
        )
        ->postJson('/api/v1/assets', [
            'name' => 'MacBook Pro',

            'asset_category_id' => $category->id,

            'asset_status_id' => $status->id,
        ]);

    $response
        ->assertCreated()
        ->assertJson([
            'success' => true,
            'message' => 'Asset created successfully',
        ]);

    $this->assertDatabaseHas('assets', [
        'name' => 'MacBook Pro',
    ]);
});