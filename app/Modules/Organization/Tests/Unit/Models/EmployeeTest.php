<?php


use App\Modules\Organization\Models\Branch;
use App\Modules\Organization\Models\Department;
use App\Modules\Organization\Models\Employee;
use App\Modules\Organization\Models\Position;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class
);
it('belongs to branch', function () {

    $relation = (new Employee())
        ->branch();

    expect($relation)
        ->toBeInstanceOf(
            BelongsTo::class
        );

    expect($relation->getRelated())
        ->toBeInstanceOf(
            Branch::class
        );
});

it('belongs to department', function () {

    $relation = (new Employee())
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

it('belongs to position', function () {

    $relation = (new Employee())
        ->position();

    expect($relation)
        ->toBeInstanceOf(
            BelongsTo::class
        );

    expect($relation->getRelated())
        ->toBeInstanceOf(
            Position::class
        );
});

