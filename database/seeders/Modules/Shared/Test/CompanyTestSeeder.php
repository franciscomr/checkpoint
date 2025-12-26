<?php

namespace Database\Seeders\Modules\Shared\Test;

use App\Models\User;
use App\Modules\Company\Domain\Models\Branch;
use App\Modules\Company\Domain\Models\Company;
use App\Modules\Company\Domain\Models\CompanyDepartment;
use App\Modules\Company\Domain\Models\CompanyPosition;
use App\Modules\Company\Domain\Models\DepartmentTemplate;
use App\Modules\Company\Domain\Models\Employee;
use App\Modules\Company\Domain\Models\PositionTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Francisco Martinez',
            'email' => 'francisco.martinez@sagaji.com.mx',
            'password' => bcrypt('Sagaji01'),
        ]);

        Company::factory()->count(5)->create();
        Branch::factory()->count(10)->create();
        DepartmentTemplate::factory()->count(20)->create();
        PositionTemplate::factory()->count(40)->create();
        CompanyDepartment::factory()->count(20)->create();
        CompanyPosition::factory()->count(40)->create();
        Employee::factory()->count(100)->create();

        User::create([
            'name' => 'Marco Panales',
            'email' => 'marco.panales@sagaji.com.mx',
            'password' => bcrypt('Sagaji02'),
            'employee_id' => 2
        ]);
    }
}
