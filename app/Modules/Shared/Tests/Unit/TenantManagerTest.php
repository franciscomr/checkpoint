<?php

use App\Modules\Shared\Models\Tenant;
use App\Modules\Shared\Services\TenantManager;

it('stores the current tenant', function () {

    $tenant = new Tenant([
        'name' => 'Acme Corp',
        'slug' => 'acme',
    ]);

    $manager = new TenantManager();

    $manager->setTenant($tenant);

    expect(
        $manager->getTenant()
    )->toBe($tenant);
});

it('returns the tenant id', function () {

    $tenant = new Tenant();

    $tenant->id = '01JV123ABC';

    $manager = new TenantManager();

    $manager->setTenant($tenant);

    expect(
        $manager->getTenantId()
    )->toBe('01JV123ABC');
});

it('returns null when no tenant exists', function () {

    $manager = new TenantManager();

    expect(
        $manager->getTenant()
    )->toBeNull();

    expect(
        $manager->getTenantId()
    )->toBeNull();
});