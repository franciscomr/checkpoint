<?php

namespace App\Modules\Shared\Database\Factories;

use App\Modules\Organization\Models\Department;
use App\Modules\Organization\Models\Position;
use App\Modules\Shared\Database\Factories\Concerns\HasTenantFactoryState;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Position>
 */
class PositionFactory extends Factory
{
    use HasTenantFactoryState;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Position::class;
    public function definition(): array
    {
        return [ 
        'name' => fake()->jobTitle(), 
        ];
    }

    public function withDepartment( Department $department ): static 
    { 
        return $this->state(
            [ 
                'tenant_id' => $department->tenant_id, 
                'department_id' => $department->id, 
            ]); 
    }
}
