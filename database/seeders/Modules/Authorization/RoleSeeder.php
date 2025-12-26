<?php

namespace Database\Seeders\Modules\Authorization;

use App\Modules\Authorization\Domain\Models\Permission;
use App\Modules\Authorization\Domain\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Catálogo oficial de Roles
         * -------------------------
         * - Super Admin: Acceso total al sistema
         * - Company Owner: Control total dentro de su empresa
         * - Company Admin: Gestión operativa de la empresa
         * - HR Manager: Gestión de empleados, departamentos y posiciones
         * - Branch Manager: Gestión limitada a sucursales y empleados
         * - Employee: Acceso básico
         */


        $roles = [
            'super_admin' => [
                'name' => 'Super Admin',
                'description' => 'Full system access',
                'permissions' => Permission::pluck('id')->toArray(),
            ],

            'company_owner' => [
                'name' => 'Company Owner',
                'description' => 'Full access within owned companies',
                'permissions' => [
                    'company.view',
                    'company.update',
                    'company.delete',
                    'branch.*',
                    'employee.*',
                    'department.*',
                    'position.*',
                ],
            ],


            'company_admin' => [
                'name' => 'Company Admin',
                'description' => 'Administrative access within company',
                'permissions' => [
                    'company.view',
                    'branch.*',
                    'employee.*',
                    'department.*',
                    'position.*',
                ],
            ],


            'hr_manager' => [
                'name' => 'HR Manager',
                'description' => 'Human Resources management',
                'permissions' => [
                    'employee.*',
                    'department.*',
                    'position.*',
                ],
            ],


            'branch_manager' => [
                'name' => 'Branch Manager',
                'description' => 'Branch and staff management',
                'permissions' => [
                    'branch.view',
                    'branch.update',
                    'employee.view',
                    'employee.update',
                ],
            ],


            'employee' => [
                'name' => 'Employee',
                'description' => 'Basic employee access',
                'permissions' => [
                    'company.view',
                    'branch.view',
                    'employee.view',
                ],
            ],
        ];


        foreach ($roles as $slug => $data) {
            $role = Role::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                ]
            );


            // Resolver permisos
            if ($slug === 'super_admin') {
                $role->permissions()->sync($data['permissions']);
                continue;
            }


            $permissionIds = Permission::query()
                ->where(function ($query) use ($data) {
                    foreach ($data['permissions'] as $pattern) {
                        if (str_ends_with($pattern, '.*')) {
                            $query->orWhere('slug', 'like', rtrim($pattern, '.*') . '%');
                        } else {
                            $query->orWhere('slug', $pattern);
                        }
                    }
                })
                ->pluck('id')
                ->toArray();


            $role->permissions()->sync($permissionIds);
        }
    }
}
