<?php

namespace App\Modules\Shared\Database\Factories;

use App\Modules\Shared\Database\Factories\Concerns\HasTenantFactoryState;
use App\Modules\Shared\Models\Role;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Role>
 */
class RoleFactory extends Factory
{
    use HasTenantFactoryState;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Role::class;
    public function definition(): array
    {
        $name = fake()->unique()->jobTitle();

        return [
            'tenant_id' => Tenant::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn () => [
            'name' => 'Administrator',
            'slug' => 'admin',
        ]);
    }

    public function manager(): static
    {
        return $this->state(fn () => [
            'name' => 'Manager',
            'slug' => 'manager',
        ]);
    }

    public function employee(): static
{
    return $this->state(fn () => [
        'name' => 'Employee',
        'slug' => 'employee',
    ]);
}
}
