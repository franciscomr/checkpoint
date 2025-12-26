<?php

namespace Database\Seeders\Modules\Authorization;

use App\Modules\Authorization\Domain\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // =============================
            // Company
            // =============================
            ['name' => 'View companies', 'slug' => 'company.viewAny', 'module' => 'company'],
            ['name' => 'Create company', 'slug' => 'company.create', 'module' => 'company'],
            ['name' => 'View company', 'slug' => 'company.view', 'module' => 'company'],
            ['name' => 'Update company', 'slug' => 'company.update', 'module' => 'company'],
            ['name' => 'Delete company', 'slug' => 'company.delete', 'module' => 'company'],

            // =============================
            // Branch
            // =============================
            ['name' => 'View branches', 'slug' => 'branch.viewAny', 'module' => 'branch'],
            ['name' => 'Create branch', 'slug' => 'branch.create', 'module' => 'branch'],
            ['name' => 'View branch', 'slug' => 'branch.view', 'module' => 'branch'],
            ['name' => 'Update branch', 'slug' => 'branch.update', 'module' => 'branch'],
            ['name' => 'Delete branch', 'slug' => 'branch.delete', 'module' => 'branch'],

            // =============================
            // Employee
            // =============================
            ['name' => 'View employees', 'slug' => 'employee.viewAny', 'module' => 'employee'],
            ['name' => 'Create employee', 'slug' => 'employee.create', 'module' => 'employee'],
            ['name' => 'View employee', 'slug' => 'employee.view', 'module' => 'employee'],
            ['name' => 'Update employee', 'slug' => 'employee.update', 'module' => 'employee'],
            ['name' => 'Delete employee', 'slug' => 'employee.delete', 'module' => 'employee'],

            // =============================
            // Department
            // =============================
            ['name' => 'View departments', 'slug' => 'department.viewAny', 'module' => 'department'],
            ['name' => 'Create department', 'slug' => 'department.create', 'module' => 'department'],
            ['name' => 'View department', 'slug' => 'department.view', 'module' => 'department'],
            ['name' => 'Update department', 'slug' => 'department.update', 'module' => 'department'],
            ['name' => 'Delete department', 'slug' => 'department.delete', 'module' => 'department'],

            // =============================
            // Position
            // =============================
            ['name' => 'View positions', 'slug' => 'position.viewAny', 'module' => 'position'],
            ['name' => 'Create position', 'slug' => 'position.create', 'module' => 'position'],
            ['name' => 'View position', 'slug' => 'position.view', 'module' => 'position'],
            ['name' => 'Update position', 'slug' => 'position.update', 'module' => 'position'],
            ['name' => 'Delete position', 'slug' => 'position.delete', 'module' => 'position'],
        ];


        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }
    }
}
