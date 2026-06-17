<?php

namespace App\Modules\Shared\Database\Factories;

use App\Modules\Assets\Models\AssetCategory;
use App\Modules\Assets\Models\AssetModel;
use App\Modules\Shared\Database\Factories\Concerns\HasTenantFactoryState;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AssetModel>
 */
class AssetModelFactory extends Factory
{
    use HasTenantFactoryState;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = AssetModel::class;
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),

            'asset_category_id' => AssetCategory::factory(),

            'brand' => fake()->company(),

            'name' => fake()->bothify('Model-###'),

            'manufacturer_part_number' => fake()->bothify('MPN-#####'),

            'description' => fake()->sentence(),
        ];
    }

}
