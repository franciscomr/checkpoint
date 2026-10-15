<?php

namespace App\Modules\Shared\Database\Seeders;

use App\Models\User;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $acme = Tenant::create([
            'name' => 'Checkpoint Acme',
            'slug' => 'checkpoint-acme',
            'domain' => 'acme.checkpoint.test',
        ]);

        $globex = Tenant::create([
            'name' => 'Checkpoint Globex',
            'slug' => 'checkpoint-globex',
            'domain' => 'globex.checkpoint.test',
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@checkpoint.com',
            'password' => 'password',
            'tenant_id' => $acme->id,
        ]);

        User::create([
            'name' => 'admin',
            'email' => 'admin@checkpoint.com',
            'password' => 'password',
            'tenant_id' => $acme->id,
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@checkpoint.com',
            'password' => 'password',
            'tenant_id' => $globex->id,
        ]);
    }
}
