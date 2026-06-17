<?php

namespace App\Modules\Shared\Database\Factories;

use App\Modules\Assets\Models\Supplier;
use App\Modules\Shared\Database\Factories\Concerns\HasTenantFactoryState;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Supplier>
 */
class SupplierFactory extends Factory
{
    use HasTenantFactoryState;
    protected $model = Supplier::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),

            'name' => fake()->company(),

            'contact_name' => fake()->name(),

            'email' => fake()->safeEmail(),

            'phone' => fake()->phoneNumber(),

            'notes' => fake()->sentence(),
        ];
    }

}
