<?php

namespace Database\Factories\Shared;

use App\Modules\Shared\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Tenant>
 */
class TenantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Tenant::class;
    public function definition(): array
    {
        $companyName = fake()->company().' - '.Str::random(5);
        return [
            'name' => $companyName,
            'slug' => Str::slug($companyName),
        ];
    }
}
