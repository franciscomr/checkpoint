<?php

namespace App\Modules\Shared\Database\Factories;

use App\Models\Model;
use App\Models\User;
use App\Modules\Assets\Enums\AssetMovementType;
use App\Modules\Assets\Models\Asset;
use App\Modules\Organization\Models\Employee;
use App\Modules\Shared\Database\Factories\Concerns\HasTenantFactoryState;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Assets\Models\AssetMovement;

/**
 * @extends Factory<AssetMovement>
 */
class AssetMovementFactory extends Factory
{
    use HasTenantFactoryState;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = AssetMovement::class;
    public function definition(): array
    {
        $tenant = Tenant::factory()->create(); 
        $employee = Employee::factory() ->organizationalHierarchy($tenant) ->create(); 
        $asset = Asset::factory() ->forTenant($tenant) ->create(); 
        return [ 
            'tenant_id' => $tenant->id, 
            'asset_id' => $asset->id, 
            'employee_id' => $employee->id, 
            'movement_type' => $this->assigned(), 
            'created_at' => now(), 
            'notes' => fake()->sentence(), 
        ];
        /*
        $tenant = Tenant::factory()->create();

        return [
            'tenant_id' => $tenant->id,
            'asset_id' => Asset::factory()->forTenant($tenant),
            'type' => AssetMovementType::CREATED,
            'from_employee_id' => null,
            'to_employee_id' => null,
            'from_status_id' => null,
            'to_status_id' => null,
            'notes' => fake()->optional()->sentence(),
            'created_by' => User::factory(),
            'created_at' => now(),
        ];
        */
    }

    public function assigned(): static
    {
        return $this->state(fn () => [
            'movement_type' => AssetMovementType::ASSIGNED,
        ]);
    }

    public function transferred(): static
    {
        return $this->state(fn () => [
            'movement_type' => AssetMovementType::TRANSFERRED,
        ]);
    }

    public function returned(): static
    {
        return $this->state(fn () => [
            'movement_type' => AssetMovementType::RETURNED,
        ]);
    }

    public function retired(): static
    {
        return $this->state(fn () => [
            'movement_type' => AssetMovementType::RETIRED,
        ]);
    }
}
