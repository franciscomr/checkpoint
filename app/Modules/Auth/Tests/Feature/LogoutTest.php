<?php

use App\Models\User;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class
);

it('can logout authenticated user', function () {

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
        ->postJson('/api/v1/logout');

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
            'message' => 'Logout successful',
        ]);

    expect($user->tokens()->count())
        ->toBe(0);
});

it('requires authentication to logout', function () {

    $tenant = Tenant::factory()->create();

    $response = $this
        ->withHeader('X-Tenant-ID', $tenant->id)
        ->postJson('/api/v1/logout');

    $response->assertUnauthorized();
});