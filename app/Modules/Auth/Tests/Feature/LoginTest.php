<?php

use App\Models\User;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class
);


it('can login successfully', function () {

    $tenant = Tenant::factory()->create();

    User::factory()->create([
        'tenant_id' => $tenant->id,
        'email' => 'admin@test.com',
        'password' => bcrypt('password'),
        'is_active' => true,
    ]);

    $response = $this
        ->withHeader(
            'X-Tenant-ID',
            $tenant->id
        )
        ->postJson('/api/v1/login', [
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);

    $response
        ->assertOk();

    $response
        ->assertJson([
            'success' => true,
        ]);

    $response
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'token',
                'token_type',
                'user',
            ],
        ]);
});

it('cannot login with invalid credentials', function () {

    $tenant = Tenant::factory()->create();

    User::factory()->create([
        'tenant_id' => $tenant->id,
        'email' => 'admin@test.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this
        ->withHeader('X-Tenant-ID', $tenant->id)
        ->postJson('/api/v1/login', [
            'email' => 'admin@test.com',
            'password' => 'wrong-password',
        ]);

    $response
        ->assertUnauthorized()
        ->assertJson([
            'success' => false,
            'code' => 'AUTH_INVALID_CREDENTIALS',
        ]);
});

it('cannot login when user is inactive', function () {

    $tenant = Tenant::factory()->create();

    User::factory()->inactive()->create([
        'tenant_id' => $tenant->id,
        'email' => 'admin@test.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this
        ->withHeader('X-Tenant-ID', $tenant->id)
        ->postJson('/api/v1/login', [
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);

    $response
        ->assertForbidden();
});

it('requires tenant header', function () {

    $response = $this
        ->postJson('/api/v1/login', [
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);

    $response
        ->assertStatus(400)
        ->assertJson([
            'success' => false,
            'code' => 'TENANT_HEADER_MISSING',
        ]);
});

it('fails when tenant does not exist', function () {

    $response = $this
        ->withHeader(
            'X-Tenant-ID',
            '01ZZZZZZZZZZZZZZZZZZZZZZZZ'
        )
        ->postJson('/api/v1/login', [
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);

    $response
        ->assertNotFound();
});

it('cannot login user from another tenant', function () {

    $tenantA = Tenant::factory()->create();

    $tenantB = Tenant::factory()->create();

    User::factory()->create([
        'tenant_id' => $tenantA->id,
        'email' => 'admin@test.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this
        ->withHeader('X-Tenant-ID', $tenantB->id)
        ->postJson('/api/v1/login', [
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);

    $response->assertUnauthorized();
});



