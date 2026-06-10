<?php

namespace App\Modules\Shared\Database\Seeders;

use App\Models\User;
use App\Modules\Shared\Models\Branch;
use App\Modules\Shared\Models\Department;
use App\Modules\Shared\Models\Employee;
use App\Modules\Shared\Models\Permission;
use App\Modules\Shared\Models\Position;
use App\Modules\Shared\Models\Role;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = Tenant::create([
            'name' => 'Acme Corp',
            'slug' => 'acme',
        ]);

        $permissions = [
            'config.me',
            'companies.read',
            'companies.create',
            'companies.update',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'slug' => $permission,
                'module' => explode('.', $permission)[0],
            ]);
        }

        $adminRole = Role::create([
            'tenant_id' => $tenant->id,
            'name' => 'Administrator',
            'slug' => 'admin',
        ]);

        $adminRole->permissions()->sync(Permission::pluck('id'));

        $userRole = Role::create([
            'tenant_id' => $tenant->id,
            'name' => 'User',
            'slug' => 'user',
        ]);

        $userRole->permissions()->sync(Permission::where('module', 'companies')->pluck('id'));

        $user = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Francisco Martinez',
            'email' => 'francisco.martinez@sagaji.com.mx',
            'password' => bcrypt('Sagaji02'),
        ]);

        $user2 = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Marco Panales',
            'email' => 'marco.panales@sagaji.com.mx',
            'password' => bcrypt('Sagaji02'),
        ]);

/*
        Branch::factory()->count(2)->create();
        Department::factory()->count(6)->create();
        Position::factory()->count(12)->create();
        Employee::factory()->count(10)->create();
*/
        $user->roles()->attach($adminRole->id);
        $user2->roles()->attach($userRole->id);
    }
}
