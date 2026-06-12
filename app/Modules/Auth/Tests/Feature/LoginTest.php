<?php

use App\Models\User;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class
);

it('can login successfully', function () {

    $tenant = Tenant::factory()->create();

    $user = User::factory()->create([
        'tenant_id' => $tenant->id,
        'email' => 'admin@test.com',
        'password' => bcrypt('password'),
        'is_active' => true,
    ]);

    $response = $this
        ->withHeader('X-Tenant-ID', $tenant->id)
        ->postJson('/api/v1/login', [
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);

    $response
        ->assertOk()
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



