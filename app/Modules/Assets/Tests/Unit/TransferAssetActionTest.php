<?php

use App\Modules\Assets\Actions\AssignAssetAction;
use App\Modules\Assets\Actions\TransferAssetAction;
use App\Modules\Assets\DTO\AssignAssetDTO;
use App\Modules\Assets\DTO\TransferAssetDTO;
use App\Modules\Assets\Enums\AssetMovementType;
use App\Modules\Assets\Exceptions\AssetAssignmentException;
use App\Modules\Assets\Models\Asset;
use App\Modules\Assets\Models\AssetAssignment;
use App\Modules\Assets\Models\AssetMovement;
use App\Modules\Assets\Models\AssetStatus;
use App\Modules\Organization\Models\Employee;
use App\Modules\Shared\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class,
);

beforeEach(function () {
    $this->tenant = Tenant::factory()->create();

    $this->availableStatus = AssetStatus::factory()->forTenant($this->tenant)->create(
        [
            'name' => 'Available',
            'slug' => 'available',
            'is_assignable' => true,
        ]
    );
    $this->assignedStatus = AssetStatus::factory()->forTenant($this->tenant)->create(
        [
            'name' => 'Assigned',
            'slug' => 'assigned',
            'is_assignable' => true,
        ]
    );
    $this->transferredStatus = AssetStatus::factory()->forTenant($this->tenant)->create(
        [
            'name' => 'Transferred',
            'slug' => 'transferred',
            'is_assignable' => true,
        ]
    );


    $this->employeeA = Employee::factory()->organizationalHierarchy($this->tenant)->create();

    $this->employeeB = Employee::factory()->organizationalHierarchy($this->tenant)->create();

    $this->asset = Asset::factory()
        ->forTenant($this->tenant)
        ->create([
            'asset_status_id' => $this->assignedStatus->id,
            'assigned_employee_id' => $this->employeeA->id,
        ]);

    $this->assetAssignment = AssetAssignment::factory()->create([
        'tenant_id' => $this->tenant->id,
        'asset_id' => $this->asset->id,
        'employee_id' => $this->employeeA->id,
        'assigned_at' => now()->subDays(10),
    ]);

});


it('transfers asset to another employee', function () {

    $dto = new TransferAssetDTO(
        assetId: $this->asset->id,
        employeeId: $this->employeeB,
        transferredAt: now(),
    );

    app(
        TransferAssetAction::class
    )->execute($dto);

    $this->asset->refresh();

    expect(
        $this->asset->assigned_employee_id
    )->toBe(
        $this->employeeB->id
    );

});

it('closes previous assignment', function () {

    $dto = new TransferAssetDTO(
        assetId: $this->asset->id,
        employeeId: $this->employeeB,
        transferredAt: now(),
    );

    app(
        TransferAssetAction::class
    )->execute($dto);

    $oldAssignment = AssetAssignment::query()
        ->where('employee_id', $this->employeeA->id)
        ->first();

    expect(
        $oldAssignment->returned_at
    )->not->toBeNull();

});


it('creates new assignment', function () {

    $dto = new TransferAssetDTO(
        assetId: $this->asset->id,
        employeeId: $this->employeeB,
        transferredAt: now(),
    );

    app(
        TransferAssetAction::class
    )->execute($dto);

    $assignment = AssetAssignment::query()
        ->where('employee_id', $this->employeeB->id)
        ->whereNull('returned_at')
        ->first();

    expect($assignment)->not->toBeNull();

});


it('keeps asset assigned', function () {

    $dto = new TransferAssetDTO(
        assetId: $this->asset->id,
        employeeId: $this->employeeB,
        transferredAt: now(),
    );

    app(
        TransferAssetAction::class
    )->execute($dto);

    $this->asset->refresh();

    expect(
        $this->asset->asset_status_id
    )->toBe(
        $this->assignedStatus->id
    );

});


it('creates transfer movement', function () {

    $dto = new TransferAssetDTO(
        assetId: $this->asset->id,
        employeeId: $this->employeeB,
        transferredAt: now(),
    );

    app(
        TransferAssetAction::class
    )->execute($dto);

    $movement = AssetMovement::query()
        ->latest()
        ->first();


    expect($movement)->not->toBeNull();

    expect(
        $movement->movement_type
    )->toBe(
        AssetMovementType::TRANSFERRED
    );

    expect(
        $movement->from_employee_id
    )->toBe(
        $this->employeeA->id
    );

    expect(
        $movement->to_employee_id
    )->toBe(
        $this->employeeB->id
    );

});

it('stores transfer notes', function () {


    $dto = new TransferAssetDTO(
        assetId: $this->asset->id,
        employeeId: $this->employeeB,
        transferredAt: now(),
        transferNotes: 'Transferencia por cambio de departamento.'
    );

    app(
        TransferAssetAction::class
    )->execute($dto);

    $movement = AssetMovement::latest()->first();

    expect(
        $movement->movement_notes
    )->toBe(
        'Transferencia por cambio de departamento.'
    );

});


it('throws exception when no active assignment exists', function () {

    expect(fn () => app(
        TransferAssetAction::class
    )->execute(
        new TransferAssetDTO(
            assetId: $this->asset->id,
            employeeId: $this->employeeA,
            transferredAt: now(),
        )
    ))->toThrow(
        AssetAssignmentException::class,
        'Cannot transfer to same Employee'
    );

});


it('throws exception when transferring to same employee', function () {

    expect(fn () => app(
        TransferAssetAction::class
    )->execute(
        new TransferAssetDTO(
            assetId: $this->asset->id,
            employeeId: $this->employeeA,
            transferredAt: now(),
        )
    ))->toThrow(
        AssetAssignmentException::class
    );

});


it('throws exception when employee belongs to another tenant', function () {

    $tenantB = Tenant::factory()->create();


    $employeeB = Employee::factory()
        ->organizationalHierarchy($tenantB)
        ->create();



    expect(fn () => app(
        TransferAssetAction::class
    )->execute(
        new TransferAssetDTO(
            assetId: $this->asset->id,
            employeeId: $employeeB,
            transferredAt: now(),
        )
    ))->toThrow(
        AssetAssignmentException::class
    );

});
