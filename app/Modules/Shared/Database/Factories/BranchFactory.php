<?php

namespace App\Modules\Shared\Database\Factories;

use App\Modules\Organization\Models\Branch;
use App\Modules\Shared\Database\Factories\Concerns\HasTenantFactoryState;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Branch>
 */
class BranchFactory extends Factory
{
    use HasTenantFactoryState;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Branch::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(), 
            'name' => fake()->company(), 
            'address' => fake()->streetAddress(), 
            'city' => fake()->city(), 
            'state' => fake()->state(), 
            'postal_code' => fake()->postcode(), 
            'is_active' => true,
        ];
    }

    public function inactive(): static 
    { 
        return $this->state(fn () => [ 'is_active' => false, ]); 
    }
}
