<?php

use App\Modules\Shared\Models\Tenant;
use App\Modules\Shared\Services\TenantResolver;
use App\Modules\Shared\Exceptions\TenantNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class
);
it('resolves a tenant by slug', function () {

    $tenant = Tenant::create([
        'name' => 'Acme Corp',
        'slug' => 'acme',
    ]);

    $resolver = app(TenantResolver::class);

    $result = $resolver->resolve('acme');

    expect(
        $result->id
    )->toBe($tenant->id);
});

it('throws exception when tenant does not exist', function () {

    $resolver = app(TenantResolver::class);

    $resolver->resolve('unknown');

})->throws(TenantNotFoundException::class);
