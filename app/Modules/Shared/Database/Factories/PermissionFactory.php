<?php

namespace App\Modules\Shared\Database\Factories;

use App\Modules\Shared\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Permission>
 */
class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Permission::class;
    public function definition(): array
    {
        $action = fake()->randomElement([
            'view',
            'create',
            'update',
            'delete',
        ]);

        $module = fake()->randomElement([
            'assets',
            'employees',
            'branches',
            'departments',
        ]);

        return [
            'name' => Str::headline("{$module} {$action}"),
            'slug' => "{$module}.{$action}",
            'module' => $module,
        ];
    }

    public function assetsView(): static
    {
        return $this->state(fn () => [
            'name' => 'View Assets',
            'slug' => 'assets.view',
            'module' => 'assets',
        ]);
    }

    public function assetsCreate(): static
    {
        return $this->state(fn () => [
            'name' => 'Create Assets',
            'slug' => 'assets.create',
            'module' => 'assets',
        ]);
    }
}
