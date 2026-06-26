<?php

use App\Modules\Assets\Actions\AssignAssetAction;
use App\Modules\Assets\DTO\AssignAssetDTO;
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
    $this->assignedStatus = AssetStatus::factory()->forTenant($this->tenant)->create(
        [
            'name' => 'Assigned',
            'slug' => 'assigned',
            'is_assignable' => true,
        ]
    );
    $this->availableStatus = AssetStatus::factory()->forTenant($this->tenant)->create([
        'name' => 'Available',
        'slug' => 'available',
        'is_assignable' => true,
    ]);
    $this->asset = Asset::factory()->forTenant($this->tenant)->create([
            'asset_status_id' => $this->availableStatus->id,
    ]);
    $this->employee = Employee::factory()->organizationalHierarchy($this->tenant)->create();
});

it('assigns asset to employee', function () {

    $dto = new AssignAssetDTO(
        assetId: $this->asset->id,
        employeeId: $this->employee->id,
        assignedAt: now()
    );

    $assignment = app(AssignAssetAction::class)->execute($dto);

    expect($assignment)->toBeInstanceOf(AssetAssignment::class);

    expect($assignment->asset_id)->toBe($this->asset->id);

    expect($assignment->employee_id)->toBe($this->employee->id);

});



it('creates active assignment', function () {

    $dto = new AssignAssetDTO(
        assetId: $this->asset->id,
        employeeId: $this->employee->id,
        assignedAt: now()
    );

    $assignment = app(AssignAssetAction::class)->execute($dto);

    expect($assignment->returned_at)->toBeNull();

    expect($assignment->isActive())->toBeTrue();

});


it('updates assigned employee on asset', function () {


    $asset = Asset::factory()
        ->forTenant($this->tenant)
        ->create([
            'asset_status_id' => $this->availableStatus->id,
        ]);

    $dto = new AssignAssetDTO(
        assetId: $asset->id,
        employeeId: $this->employee->id,
        assignedAt: now()
    );

    app(AssignAssetAction::class)->execute($dto);

    $asset->refresh();

    expect($asset->assigned_employee_id)->toBe($this->employee->id);

});


it('updates asset status to assigned', function () {

    $dto = new AssignAssetDTO(
        assetId: $this->asset->id,
        employeeId: $this->employee->id,
        assignedAt: now()
    );

    app(AssignAssetAction::class)->execute($dto);

    expect(
        $this->asset->fresh()->asset_status_id
    )->toBe(
        $this->assignedStatus->id
    );


});


it('creates assignment movement', function () {

    $dto = new AssignAssetDTO(
        assetId: $this->asset->id,
        employeeId: $this->employee->id,
        assignedAt: now()
    );

    app(AssignAssetAction::class)->execute($dto);

    $movement = AssetMovement::query()->first();

    expect($movement)->not->toBeNull();

    expect($movement->movement_type)
        ->toBe(
            AssetMovementType::ASSIGNED
        );

    expect($movement->to_employee_id)
        ->toBe(
            $this->employee->id
        );

});


it('throws exception when asset is already assigned', function () {

    AssetAssignment::factory()->create([
        'tenant_id' => $this->tenant->id,
        'asset_id' => $this->asset->id,
        'employee_id' => $this->employee->id,
        'assigned_at' => now(),
        'returned_at' => null,
    ]);

    $dto = new AssignAssetDTO(
        assetId: $this->asset->id,
        employeeId: $this->employee->id,
        assignedAt: now()
    );

    expect(
        fn () => app(AssignAssetAction::class)->execute($dto))
        ->toThrow(
        AssetAssignmentException::AssetAlreadyAssignedException()
        );

});






