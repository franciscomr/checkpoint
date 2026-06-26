<?php

namespace App\Modules\Assets\Actions;

use App\Modules\Assets\DTO\AssignAssetDTO;
use App\Modules\Assets\Enums\AssetMovementType;
use App\Modules\Assets\Models\Asset;
use App\Modules\Assets\Models\AssetAssignment;
use App\Modules\Assets\Models\AssetMovement;
use App\Modules\Assets\Models\AssetStatus;
use App\Modules\Assets\Services\AssetAssignmentService;
use App\Modules\Assets\Services\AssetMovementService;
use App\Modules\Organization\Models\Employee;
use Illuminate\Support\Facades\DB;
use App\Modules\Assets\Exceptions\AssetAssignmentException;
use App\Modules\Organization\Exceptions\EmployeeException;
class AssignAssetAction
{
    public function __construct(
        protected AssetAssignmentService $assignmentService,
        protected AssetMovementService $assetMovementService){}
    public function execute( AssignAssetDTO $dto ): AssetAssignment { 
        return DB::transaction(function () use ($dto) { 
            $asset = $this->assignmentService->findAsset($dto->assetId);
            
            $employee = Employee::query() ->find($dto->employeeId); 
            if (! $employee) { 
                throw  EmployeeException::EmployeeNotFoundException(); 
            } 

            $this->assignmentService->assertNotAssigned($asset);

            $assignment = AssetAssignment::query() ->create([ 
                    'tenant_id' => $asset->tenant_id,
                    'asset_id' => $asset->id,
                    'employee_id' => $employee->id,
                    'assigned_at' => $dto->assignedAt,
                    'expected_return_at' => $dto->expectedReturnAt,
                    'assignment_notes' => $dto->assignmentNotes,
            ]); 

            $assignedStatus = $this->assignmentService->findAssignedStatus($asset);
            
            $this->assignmentService->assignAsset($asset,$employee,$assignedStatus);

            $this->assetMovementService->record(
                asset: $asset,
                movementType: AssetMovementType::ASSIGNED,
                toEmployee: $employee,
                fromStatus: null,
                toStatus: $asset->status,
                movementNotes: $dto->assignmentNotes,
            );
            
            return $assignment->fresh([ 'asset', 'employee', ]); 
        }); 
    }  
}
