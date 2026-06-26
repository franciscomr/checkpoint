<?php 
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Shared\Models\Tenant;
use App\Modules\Assets\Models\AssetStatus;
use App\Modules\Assets\Models\Asset;
use App\Modules\Assets\Models\AssetMovement;

use App\Modules\Organization\Models\Employee;
use App\Modules\Assets\DTO\AssignAssetDTO;
use App\Modules\Assets\DTO\ReturnAssetDTO;
use App\Modules\Assets\Actions\AssignAssetAction;
use App\Modules\Assets\Actions\ReturnAssetAction;
use App\Modules\Assets\Exceptions\AssetAssignmentException;

use App\Modules\Assets\Enums\AssetMovementType;

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
            'asset_status_id' => $this->assignedStatus->id,
    ]);
    $this->employee = Employee::factory()->organizationalHierarchy($this->tenant)->create();

});


it("returns assigned asset", function () {
    $dto = new AssignAssetDTO(
        assetId: $this->asset->id,
        employeeId: $this->employee->id,
        assignedAt: now()
    );

    app(AssignAssetAction::class)->execute($dto);

    $returnedAt = now();

    $ReturnAssetDTO = new ReturnAssetDTO(
        assetId: $this->asset->id,
        returnedAt: $returnedAt
    );

    $assignment = app(ReturnAssetAction::class)->execute($ReturnAssetDTO);  

    expect($assignment->returned_at)
        ->not
        ->toBeNull();
});


it('closes active assignment', function () {

    $dto = new AssignAssetDTO(
        assetId: $this->asset->id,
        employeeId: $this->employee->id,
        assignedAt: now()
    );

    app(AssignAssetAction::class)->execute($dto);

    $returnedAt = now();

    $ReturnAssetDTO = new ReturnAssetDTO(
        assetId: $this->asset->id,
        returnedAt: $returnedAt
    );

    $assignment = app(ReturnAssetAction::class)->execute($ReturnAssetDTO);  

    expect(
        $assignment->isActive()
    )->toBeFalse();
});


it('clears assigned employee from asset', function () {

    $dto = new AssignAssetDTO(
        assetId: $this->asset->id,
        employeeId: $this->employee->id,
        assignedAt: now()
    );

    app(AssignAssetAction::class)->execute($dto);

    $returnedAt = now();

    $ReturnAssetDTO = new ReturnAssetDTO(
        assetId: $this->asset->id,
        returnedAt: $returnedAt
    );

    $assignment = app(ReturnAssetAction::class)->execute($ReturnAssetDTO);  


    $this->asset->refresh();

    expect(
        $this->asset->assigned_employee_id
    )->toBeNull();
});


it('changes asset status to available', function () {

    $dto = new AssignAssetDTO(
        assetId: $this->asset->id,
        employeeId: $this->employee->id,
        assignedAt: now()
    );

    app(AssignAssetAction::class)->execute($dto);

    $returnedAt = now();

    $ReturnAssetDTO = new ReturnAssetDTO(
        assetId: $this->asset->id,
        returnedAt: $returnedAt
    );

    $assignment = app(ReturnAssetAction::class)->execute($ReturnAssetDTO);  

    $this->asset->refresh();

    expect(
        $this->asset->asset_status_id
    )->toBe(
        $this->availableStatus->id
    );
});


it('creates return movement', function () {

    $dto = new AssignAssetDTO(
        assetId: $this->asset->id,
        employeeId: $this->employee->id,
        assignedAt: now()
    );

    app(AssignAssetAction::class)->execute($dto);
    sleep(1);

    $returnedAt = now();

    $ReturnAssetDTO = new ReturnAssetDTO(
        assetId: $this->asset->id,
        returnedAt: $returnedAt
    );

    $this->asset->refresh();
    $assignment = app(ReturnAssetAction::class)->execute($ReturnAssetDTO);  

    $movement = AssetMovement::query()->latest()->first();

    expect(
        $movement->movement_type
    )->toBe(
        AssetMovementType::RETURNED
    );
});



it('throws exception when no active assignment exists', function () {

    expect(fn () => app(ReturnAssetAction::class)->execute(
        new ReturnAssetDTO(
            assetId: $this->asset->id,
            returnedAt: now()
        )
    ))
    ->toThrow(
        AssetAssignmentException::class
    );
});

