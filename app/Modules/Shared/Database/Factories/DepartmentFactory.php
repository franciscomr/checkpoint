<?php

namespace App\Modules\Shared\Database\Factories;

use App\Modules\Organization\Models\Branch;
use App\Modules\Organization\Models\Department;
use App\Modules\Shared\Database\Factories\Concerns\HasTenantFactoryState;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Department>
 */
class DepartmentFactory extends Factory
{
    use HasTenantFactoryState;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Department::class;
    public function definition(): array
    {
         return [ 
            'name' => fake()->randomElement([
                'TI',
                'Finanzas',
                'Ventas',
                'Recursos Humanos',
                'Mercadotecnia',
                'Operaciones',
                'Logística',
                'Compras',
                'Atención al Cliente',
                'Legal',
                'Producción',
                'Calidad',
                'Innovación',
                'Desarrollo de Producto',
                'Comunicación Corporativa',
                'Planeación Estratégica',
                'Servicio Técnico',
                'Relaciones Públicas',
                'Seguridad',
                'Administración'
            ]), 
        ];
    }


    public function withBranch(Branch $branch): static {
        return $this->state([
            'tenant_id' => $branch->tenant_id,
            'branch_id' => $branch->id,
        ]);
    }


}
