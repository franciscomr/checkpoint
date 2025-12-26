<?php

namespace Database\Seeders\Modules\Authorization;

use App\Models\User;
use App\Modules\Authorization\Domain\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Asignación inicial de roles a usuarios
         * -------------------------------------
         * Regla general:
         * - El primer usuario (id=1) es Super Admin
         * - El resto NO recibe rol por defecto
         */

        $superAdminRole = Role::where('slug', 'super_admin')->first();

        if (!$superAdminRole) {
            return;
        }

        $firstUser = User::where('id', 1)->first();

        if ($firstUser) {
            $firstUser->roles()->syncWithoutDetaching([$superAdminRole->id]);
        }
    }
}
