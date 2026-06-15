<?php

use App\Models\User;
use App\Modules\Authorization\Enums\PermissionScope;
use App\Modules\Shared\Models\Role;
use App\Modules\Shared\Models\Tenant;
use App\Modules\Shared\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class
);

it('determines if a user has a role', function () {

    $tenant = Tenant::factory()->create();

    $user = User::factory()->create([
        'tenant_id' => $tenant->id,
    ]);

    $role = Role::factory()
        ->admin()
        ->create([
            'tenant_id' => $tenant->id,
        ]);

    $user->roles()->attach($role);

    expect(
        $user->hasRole('admin')
    )->toBeTrue();

    expect(
        $user->hasRole('manager')
    )->toBeFalse();
});

it('determines if a user has any role from a list', function () {
    $tenant = Tenant::factory()->create();
    $user = User::factory()->create([
        'tenant_id'=> $tenant->id,
    ]);

    $role = Role::factory()
        ->admin()
        ->create([
            'tenant_id' => $tenant->id,
        ]);
    
    $user->roles()->attach($role);

    expect(
        $user->hasAnyRole(['admin','manager'])
    )->toBeTrue();

    expect(
        $user->hasAnyRole(['manager','employee'])
    )->toBeFalse();
});

it('determines if a user has a permission through a role', function () {
    $tenant = Tenant::factory()->create();
    $user = User::factory()->create([
        'tenant_id'=> $tenant->id
        ]);

    $role = Role::factory()
        ->employee()
        ->create([
            'tenant_id'=> $tenant->id
            ]);

    $permission = Permission::factory()
        ->assetsCreate()
        ->create();

    $role->permissions()->attach(
        $permission->id,
        ['scope'=> 'tenant']);

    $user->roles()->attach($role);

    expect(
        $user->hasPermission('assets.create')
    )->toBeTrue();

    expect(
        $user->hasPermission('assets.delete')
    )->toBeFalse();

});

it('determines if a user has any permission from a list', function () {
    $tenant = Tenant::factory()->create();

    $user = User::factory()->create([
        'tenant_id'=> $tenant->id
        ]);

    $role = Role::factory()
    ->admin()    
    ->create([
        'tenant_id'=> $tenant->id
        ]);

    $permission = Permission::factory()
    ->assetsCreate()
    ->create();

    $role->permissions()->attach($permission->id, 
    ['scope'=> 'tenant']
    );

    $user->roles()->attach($role);

    expect(
        $user->hasAnyPermission(['assets.create', 'assets.delete'])
    )->toBeTrue();

    expect(
        $user->hasAnyPermission(['assets.delete','employees.create'])
    )->toBeFalse();

});

it('returns all permission slugs', function () {

    $tenant = Tenant::factory()->create();

    $user = User::factory()->create([
        'tenant_id' => $tenant->id,
    ]);

    $role = Role::factory()
        ->admin()
        ->create([
            'tenant_id' => $tenant->id,
        ]);

    $view = Permission::factory()
        ->assetsView()
        ->create();

    $create = Permission::factory()
        ->assetsCreate()
        ->create();

    $role->permissions()->attach([
        $view->id => [
            'scope' => 'tenant',
        ],
        $create->id => [
            'scope' => 'tenant',
        ],
    ]);

    $user->roles()->attach($role);

    expect(
        $user->permissionSlugs()
    )->toContain(
        'assets.view',
        'assets.create'
    );
});

it('returns unique permission slugs', function () {

    $tenant = Tenant::factory()->create();

    $user = User::factory()->create([
        'tenant_id' => $tenant->id,
    ]);

    $permission = Permission::factory()
        ->assetsView()
        ->create();

    $admin = Role::factory()
        ->admin()
        ->create([
            'tenant_id' => $tenant->id,
        ]);

    $manager = Role::factory()
        ->manager()
        ->create([
            'tenant_id' => $tenant->id,
        ]);

    $admin->permissions()->attach(
        $permission->id,
        ['scope' => 'tenant']
    );

    $manager->permissions()->attach(
        $permission->id,
        ['scope' => 'tenant']
    );

    $user->roles()->attach([
        $admin->id,
        $manager->id,
    ]);

    expect(
        $user->permissionSlugs()
    )->toBe([
        'assets.view',
    ]);
});

it('returns permission scope', function () {

    $tenant = Tenant::factory()->create();

    $user = User::factory()->create([
        'tenant_id' => $tenant->id,
    ]);

    $role = Role::factory()
        ->admin()
        ->create([
            'tenant_id' => $tenant->id,
        ]);

    $permission = Permission::factory()
        ->assetsView()
        ->create();

    $role->permissions()->attach(
        $permission->id,
        ['scope' => 'branch']
    );

    $user->roles()->attach($role);

    expect(
        $user->permissionScope('assets.view')
    )->toBe(
        PermissionScope::BRANCH
    );
});

it('returns the most permissive scope', function () {

    $tenant = Tenant::factory()->create();

    $user = User::factory()->create([
        'tenant_id' => $tenant->id,
    ]);

    $permission = Permission::factory()
        ->assetsView()
        ->create();

    $admin = Role::factory()
        ->admin()
        ->create([
            'tenant_id' => $tenant->id,
        ]);

    $manager = Role::factory()
        ->manager()
        ->create([
            'tenant_id' => $tenant->id,
        ]);

    $admin->permissions()->attach(
        $permission->id,
        ['scope' => 'all']
    );

    $manager->permissions()->attach(
        $permission->id,
        ['scope' => 'branch']
    );

    $user->roles()->attach([
        $admin->id,
        $manager->id,
    ]);

    expect(
        $user->permissionScope('assets.view')
    )->toBe(
        PermissionScope::ALL
    );
});

it('returns null when permission does not exist', function () {

    $tenant = Tenant::factory()->create();

    $user = User::factory()->create([
        'tenant_id' => $tenant->id,
    ]);

    expect(
        $user->permissionScope('assets.delete')
    )->toBeNull();
});