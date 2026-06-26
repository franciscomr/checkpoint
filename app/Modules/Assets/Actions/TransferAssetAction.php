<?php

namespace App\Modules\Assets\Actions;

use App\Modules\Assets\DTO\TransferAssetDTO;
use App\Modules\Assets\Enums\AssetMovementType;
use App\Modules\Assets\Exceptions\AssetAssignmentException;
use App\Modules\Assets\Models\AssetAssignment;
use App\Modules\Assets\Services\AssetAssignmentService;
use App\Modules\Assets\Services\AssetMovementService;
use App\Modules\Organization\Exceptions\EmployeeException;
use App\Modules\Organization\Models\Employee;
use DB;

class TransferAssetAction
{
    public function __construct(
        protected AssetAssignmentService $assignmentService,
        protected AssetMovementService $assetMovementService
    ){}

    public function execute(TransferAssetDTO $dto): AssetAssignment{
        return DB::transaction(function () use ($dto) {
            $asset = $this->assignmentService->findAsset($dto->assetId);

            $currentAssignment = $this->assignmentService->findActiveAssignment($asset);

            $fromEmployee = $currentAssignment->employee;

            $toEmployee = Employee::find($dto->employeeId)->first();
            if (! $toEmployee) {
                throw EmployeeException::EmployeeNotFoundException();
            }
            $this->assignmentService->assertSameTenant($asset, $toEmployee);
            $this->assignmentService->assertDifferentEmployee($fromEmployee, $toEmployee);

            $currentAssignment->update([
                'returned_at' => $dto->transferredAt,
                'return_notes' => $dto->transferNotes,
            ]);

            $newAssignment = AssetAssignment::create([
                'tenant_id' => $asset->tenant_id,
                'asset_id' => $asset->id,
                'employee_id' => $toEmployee->id,
                'assigned_at' => $dto->transferredAt,
                'assignment_notes' => $dto->transferNotes,
            ]);

            $status = $this->assignmentService->findAssignedStatus($asset);

            $this->assignmentService->assignAsset($asset,$toEmployee,$status);

            $this->assetMovementService->record(
                asset: $asset,
                movementType: AssetMovementType::TRANSFERRED,
                fromEmployee: $fromEmployee,
                toEmployee: $toEmployee,
                fromStatus: $status,
                toStatus: $status,
                movementNotes: $dto->transferNotes,
            );

            return $newAssignment->fresh([ 'asset', 'employee', ]); 

        });
    }
}
