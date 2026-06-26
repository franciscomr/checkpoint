<?php


use App\Modules\Organization\Models\Branch;
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
it('belongs to branch', function () {

    $relation = (new Department())
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

it('has many positions', function () {

    $relation = (new Department())
        ->positions();

    expect($relation)
        ->toBeInstanceOf(
            HasMany::class
        );

    expect($relation->getRelated())
        ->toBeInstanceOf(
            Position::class
        );
});

it('has many employees', function () {

    $relation = (new Department())
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