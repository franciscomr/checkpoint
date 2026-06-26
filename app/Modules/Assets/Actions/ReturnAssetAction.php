<?php

namespace App\Modules\Assets\Actions;

use App\Modules\Assets\DTO\ReturnAssetDTO;
use App\Modules\Assets\Enums\AssetMovementType;
use App\Modules\Assets\Exceptions\AssetAssignmentException;
use App\Modules\Assets\Models\Asset;
use App\Modules\Assets\Models\AssetAssignment;
use App\Modules\Assets\Models\AssetMovement;
use App\Modules\Assets\Models\AssetStatus;
use App\Modules\Assets\Services\AssetAssignmentService;
use App\Modules\Assets\Services\AssetMovementService;
use Illuminate\Support\Facades\DB;
class ReturnAssetAction
{
    public function __construct(
        protected AssetAssignmentService $assignmentService,
        protected AssetMovementService $assetMovementService){}
    public function execute(ReturnAssetDTO $dto): AssetAssignment {
        return DB::transaction(function () use ($dto) {
            $asset = $this->assignmentService->findAsset($dto->assetId);

            $assetAssignment = $this->assignmentService->findActiveAssignment($asset);

            $previousEmployee = $assetAssignment->employee;

            $previousStatus = $asset->status;

            $assetAssignment->update([
                'returned_at' => $dto->returnedAt,
                 'return_notes' => $dto->returnNotes,
            ]);

            $availableStatus = $this->assignmentService->findAvailableStatus($asset);

            $this->assignmentService->returnAsset($asset, $availableStatus);

            $this->assetMovementService->record(
                asset : $asset,
                movementType:AssetMovementType::RETURNED,
                fromEmployee:$previousEmployee,
                fromStatus: $previousStatus,
                toStatus: $availableStatus,
                movementNotes: $dto->returnNotes
            );

            return $assetAssignment->fresh([
                    'asset',
                    'employee',
                ]);
        });
        
    }
}
        