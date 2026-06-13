<?php

use App\Models\User;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class
);

it('returns authenticated user', function () {

    $tenant = Tenant::factory()->create();

    $user = User::factory()->create([
        'tenant_id' => $tenant->id,
    ]);

    $token = $user
        ->createToken('test')
        ->plainTextToken;

    $response = $this
        ->withHeader('X-Tenant-ID', $tenant->id)
        ->withToken($token)
        ->getJson('/api/v1/me');

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
        ]);
});
