<?php

namespace App\Modules\Shared\Database\Seeders;


use App\Modules\Assets\Models\AssetCategory;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Tenant $tenant): void
    {
                $categories = [

            'Hardware',

            'Software',

            'Network',

            'Telephony',

            'Furniture',
        ];

        foreach ($categories as $name) {

            AssetCategory::query()->firstOrCreate(
                [
                    'tenant_id' => $tenant->id,
                    'slug' => str($name)->slug(),
                ],
                [
                    'tenant_id' => $tenant->id,
                    'name' => $name,
                    'slug' => str($name)->slug(),
                ]
            );
        }
    }
}
