<?php

namespace App\Modules\Shared\Database\Factories;

use App\Modules\Organization\Models\Branch;
use App\Modules\Organization\Models\Department;
use App\Modules\Organization\Models\Employee;
use App\Modules\Organization\Models\Position;
use App\Modules\Shared\Database\Factories\Concerns\HasTenantFactoryState;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    use HasTenantFactoryState;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Employee::class;
    public function definition(): array
    {

        return [ 
            'first_name' => fake()->firstName(), 
            'last_name' => fake()->lastName(), 
            'employee_code' => fake()->unique()->numerify( 'EMP-#####' ), 
            'is_active' => true, 
            'phone' => fake()->phoneNumber,
            'email' => fake()->email,
            'hire_date' => fake()->date(),
        ];
    }

    public function inactive(): static 
    { 
        return $this->state(fn () => [ 'is_active' => false, ]); 
    }


    public function withBranch(Branch $branch): static 
    {
        return $this->state([
            'tenant_id' => $branch->tenant_id,
            'branch_id' => $branch->id,
        ]);
    }

    public function withDepartment(Department $department): static 
    {
        return $this->state([
            'tenant_id' => $department->tenant_id,
            'department_id' => $department->id,
        ]);
    }

    public function withPosition(Position $position): static 
    {
        return $this->state([
            'tenant_id' => $position->tenant_id,
            'position_id' => $position->id,
        ]);
    }

    public function organizationalHierarchy(Tenant $tenant): static 
    {
        return $this->state(function () use ($tenant) {
            $branch = Branch::factory()
                ->forTenant($tenant)
                ->create();

            $department = Department::factory()
                ->withBranch($branch)
                ->create();

            $position = Position::factory()
                ->withDepartment($department)
                ->create();

            return [
                'tenant_id' => $tenant->id,

                'branch_id' => $branch->id,

                'department_id' => $department->id,

                'position_id' => $position->id,
            ];
        });
    }




}
