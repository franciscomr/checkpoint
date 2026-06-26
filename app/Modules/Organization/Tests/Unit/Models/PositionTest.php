<?php


use App\Modules\Organization\Models\Department;
use App\Modules\Organization\Models\Employee;
use App\Modules\Organization\Models\Position;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class
);
it('belongs to department', function () {

    $relation = (new Position())
        ->department();

    expect($relation)
        ->toBeInstanceOf(
            BelongsTo::class
        );

    expect($relation->getRelated())
        ->toBeInstanceOf(
            Department::class
        );
});

it('has many employees', function () {

    $relation = (new Position())
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
