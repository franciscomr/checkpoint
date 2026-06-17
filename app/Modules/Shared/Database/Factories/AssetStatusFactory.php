<?php

namespace App\Modules\Shared\Database\Factories;

use App\Modules\Assets\Models\AssetStatus;
use App\Modules\Shared\Database\Factories\Concerns\HasTenantFactoryState;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends Factory<AssetStatus>
 */
class AssetStatusFactory extends Factory
{
    use HasTenantFactoryState;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = AssetStatus::class;
    public function definition(): array
    {
        $name = fake()->unique()->word();

        return [
            'tenant_id' => Tenant::factory(),

            'name' => ucfirst($name),

            'slug' => Str::slug($name),

            'color' => fake()->hexColor(),

            'is_assignable' => fake()->boolean(),

            'sort_order' => fake()->numberBetween(1, 100),
        ];
    }

}
