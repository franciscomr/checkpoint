<?php

use App\Modules\Shared\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class
);

it('rejects requests without tenant header', function () {

    $response = $this->getJson(
        '/api/v1/tenant-test'
    );

    $response
        ->assertStatus(400)
        ->assertJson([
            'code' => 'TENANT_HEADER_MISSING',
        ]);
});

it('loads tenant from header', function () {

    $tenant = Tenant::create([
        'name' => 'Acme Corp',
        'slug' => 'acme',
    ]);

    $response = $this
        ->withHeader(
            'X-Tenant-ID',
            $tenant->id
        )
        ->getJson('/api/v1/tenant-test');

    $response
        ->assertOk()
        ->assertJson([
            'tenant_id' => $tenant->id,
        ]);
});