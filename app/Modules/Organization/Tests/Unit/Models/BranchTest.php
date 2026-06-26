
<?php


use App\Modules\Organization\Models\Branch;
use App\Modules\Organization\Models\Department;
use App\Modules\Organization\Models\Employee;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class
);
it('has many departments', function () {

    $relation = (new Branch())
        ->departments();

    expect($relation)
        ->toBeInstanceOf(
            HasMany::class
        );

    expect($relation->getRelated())
        ->toBeInstanceOf(
            Department::class
        );
});

it('has many employees', function () {

    $relation = (new Branch())
        ->employees();

    expect($relation)
        ->toBeInstanceOf(
            HasMany::class
        );

    expect($relation->getRelated())
        ->toBeInstanceOf(
            Employee::class
        );
});