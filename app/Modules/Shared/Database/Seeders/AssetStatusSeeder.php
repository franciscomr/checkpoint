<?php

namespace App\Modules\Shared\Database\Seeders;

use App\Modules\Assets\Models\AssetStatus;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Tenant $tenant): void
    {
        $statuses = [
            [
                'name' => 'In Stock',
                'slug' => 'in-stock',
                'color' => '#6B7280',
                'is_assignable' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Assigned',
                'slug' => 'assigned',
                'color' => '#22C55E',
                'is_assignable' => false,
                'sort_order' => 2,
            ],
            [
                'name' => 'Maintenance',
                'slug' => 'maintenance',
                'color' => '#F59E0B',
                'is_assignable' => false,
                'sort_order' => 3,
            ],
            [
                'name' => 'Retired',
                'slug' => 'retired',
                'color' => '#EF4444',
                'is_assignable' => false,
                'sort_order' => 4,
            ],
        ];

        foreach ($statuses as $status) {

            AssetStatus::query()->firstOrCreate(
                [
                    'tenant_id' => $tenant->id,
                    'slug' => $status['slug'],
                ],
                [
                    ...$status,
                    'tenant_id' => $tenant->id,
                ]
            );
        }
    }
}
