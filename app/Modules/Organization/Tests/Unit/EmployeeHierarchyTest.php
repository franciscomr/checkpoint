<?php
use App\Modules\Organization\Models\Employee;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class,
);
it('creates organizational hierarchy in same tenant', function(){
    $tenant = Tenant::factory()->create();

    $employee = Employee::factory()
        ->organizationalHierarchy($tenant)
        ->create();


    expect($employee->tenant_id)
        ->toBe($tenant->id);

    expect($employee->branch->tenant_id)
        ->toBe($tenant->id);

    expect($employee->department->tenant_id)
        ->toBe($tenant->id);

    expect($employee->position->tenant_id)
        ->toBe($tenant->id);
        
});