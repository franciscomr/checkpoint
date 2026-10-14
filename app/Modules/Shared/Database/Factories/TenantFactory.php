<?php

namespace App\Modules\Shared\Database\Factories;

use App\Modules\Shared\Enums\TenantStatus;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

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
        $companyName = $this->faker->unique()->company();
        $slug = Str::slug($companyName);

        return [
            'name' => $companyName,
            'slug' => $slug,
            'domain' => "{$slug}.".Arr::first(config(config('app.central_domains', 'checkpoint.test'))),
            'status' => TenantStatus::ACTIVE,
        ];
    }
}
