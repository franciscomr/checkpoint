<?php

use App\Modules\Organization\Models\Branch;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class,
);

it('belongs to tenant', function () 
{ 
    $tenant = Tenant::factory()->create(); 
    $branch = Branch::factory() ->forTenant($tenant) ->make(); 
    expect($branch->tenant_id) ->toBe($tenant->id); 
});