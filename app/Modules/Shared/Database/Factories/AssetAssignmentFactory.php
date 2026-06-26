<?php

namespace App\Modules\Shared\Database\Factories;
use App\Models\User;
use App\Modules\Assets\Models\Asset;
use App\Modules\Assets\Models\AssetAssignment;


use App\Models\Model;
use App\Modules\Organization\Models\Employee;
use App\Modules\Shared\Database\Factories\Concerns\HasTenantFactoryState;

use App\Modules\Shared\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AssetAssignment>
 */
class AssetAssignmentFactory extends Factory
{
    use HasTenantFactoryState; 
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = AssetAssignment::class;
    public function definition(): array
    {
        $tenant = Tenant::factory()->create(); 
        return 
        [ 'tenant_id' => $tenant->id, 
        'asset_id' => Asset::factory() ->forTenant($tenant), 
        'employee_id' => Employee::factory() ->forTenant($tenant), 
        'assigned_at' => now(), 'expected_return_at' => null, 
        'returned_at' => null, 'assignment_notes' => fake()->optional()->sentence(), 
        'created_by' => User::factory(), 'updated_by' => null, ];
    }

    public function returned(): static
    {
        return $this->state(fn () => [
            'returned_at' => now(),
        ]);
    }

    public function active(): static
    {
        return $this->state(fn () => [
            'returned_at' => null,
        ]);
    }
}
