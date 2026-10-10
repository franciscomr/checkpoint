<?php

namespace App\Modules\Shared\Database\Seeders;

use App\Modules\Shared\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        Tenant::create([
            'name' => 'Checkpoint Acme',
            'slug' => 'checkpoint-acme',
            'domain' => 'acme.checkpoint.test',
        ]);

        Tenant::create([
            'name' => 'Checkpoint Globex',
            'slug' => 'checkpoint-globex',
            'domain' => 'globex.checkpoint.test',
        ]);
    }
}
