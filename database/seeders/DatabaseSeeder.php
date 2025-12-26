<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Modules\Authorization\PermissionSeeder;
use Database\Seeders\Modules\Authorization\RoleSeeder;
use Database\Seeders\Modules\Authorization\UserRoleSeeder;
use Database\Seeders\Modules\Shared\Test\CompanyTestSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

            //Testing
            CompanyTestSeeder::class,

            // Catálogos base
            PermissionSeeder::class,
            RoleSeeder::class,

            // Asignaciones
            UserRoleSeeder::class,

        ]);
    }
}
