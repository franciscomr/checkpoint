<?php

namespace App\Modules\Shared\Database\Factories;

use App\Modules\Assets\Models\AssetCategory;

use App\Modules\Shared\Database\Factories\Concerns\HasTenantFactoryState;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<AssetCategory>
 */
class AssetCategoryFactory extends Factory
{
    use HasTenantFactoryState;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = AssetCategory::class;
    public function definition(): array
    {
        $name = fake()->unique()->word();

        return [
            'tenant_id' => Tenant::factory(),

            'parent_id' => null,

            'name' => ucfirst($name),

            'slug' => Str::slug($name),

            'description' => fake()->sentence(),
        ];
    }

}
