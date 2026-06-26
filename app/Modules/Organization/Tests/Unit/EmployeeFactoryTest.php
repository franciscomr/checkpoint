<?php
use App\Modules\Organization\Models\Employee;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class,
);

it('belongs to tenant', function () 
{ $tenant = Tenant::factory()->create(); 
    $employee = Employee::factory() ->forTenant($tenant) ->make(); 
    expect($employee->tenant_id) ->toBe($tenant->id); 
});