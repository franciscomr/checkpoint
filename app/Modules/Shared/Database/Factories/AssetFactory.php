<?php

namespace App\Modules\Shared\Database\Factories;

use App\Modules\Assets\Enums\AssetCriticality;
use App\Modules\Assets\Models\Asset;
use App\Modules\Assets\Models\AssetCategory;
use App\Modules\Assets\Models\AssetModel;
use App\Modules\Assets\Models\AssetStatus;
use App\Modules\Assets\Models\Supplier;
use App\Modules\Shared\Database\Factories\Concerns\HasTenantFactoryState;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Asset>
 */
class AssetFactory extends Factory
{
    use HasTenantFactoryState;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Asset::class;
    public function definition(): array
    {
        return [

            'tenant_id' => Tenant::factory(),

            'asset_tag' => fake()->unique()->bothify('AST-#####'),

            'serial_number' => fake()->optional()->uuid(),

            'name' => fake()->words(3, true),

            'asset_category_id' => AssetCategory::factory(),

            'asset_model_id' => AssetModel::factory(),

            'asset_status_id' => AssetStatus::factory(),

            'branch_id' => null,

            'department_id' => null,

            'assigned_employee_id' => null,

            'supplier_id' => Supplier::factory(),

            'purchase_date' => fake()->date(),

            'purchase_cost' => fake()->randomFloat(2, 1000, 50000),

            'invoice_number' => fake()->bothify('INV-#####'),

            'depreciation_months' => 36,

            'residual_value' => fake()->randomFloat(2, 0, 1000),

            'warranty_expiration_date' => fake()->dateTimeBetween(
                'now',
                '+3 years'
            ),

            'criticality' => fake()->randomElement(
                AssetCriticality::values()
            ),

            'business_service' => fake()->optional()->sentence(),

            'notes' => fake()->optional()->paragraph(),
        ];
    }

}
