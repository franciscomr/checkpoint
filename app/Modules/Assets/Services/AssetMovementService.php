<?php

namespace App\Modules\Assets\Services;

use App\Models\User;
use App\Modules\Assets\Enums\AssetMovementType;
use App\Modules\Assets\Models\Asset;
use App\Modules\Assets\Models\AssetMovement;
use App\Modules\Assets\Models\AssetStatus;
use App\Modules\Organization\Models\Employee;
use Carbon\CarbonInterface;

class AssetMovementService
{
    public function  record(
        Asset $asset,
        AssetMovementType $movementType,
        ?Employee  $fromEmployee = null,
        ?Employee  $toEmployee = null,
        ?AssetStatus $fromStatus = null,
        ?AssetStatus $toStatus = null,
        ?string $movementNotes = null,
        ?User  $createdBy = null,
        ?CarbonInterface $performedAt = null,
    ): AssetMovement
    {
        return AssetMovement::query()->create([
            'tenant_id'=> $asset->tenant->id,
            'asset_id' => $asset->id,
            'movement_type'=> $movementType,
            'from_employee_id'=> $fromEmployee?->id,
            'to_employee_id'=> $toEmployee?->id,
            'from_status_id'=> $fromStatus?->id,
            'to_status_id'=> $toStatus?->id,
            'movement_notes'=> $movementNotes,
            'created_by' => $createdBy?->id,
            'performed_at' => $performedAt ?? now()
        ]);
    }
}
