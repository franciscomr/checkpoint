<?php

namespace App\Modules\Assets\Services;

use App\Modules\Assets\Exceptions\AssetAssignmentException;
use App\Modules\Assets\Models\Asset;
use App\Modules\Assets\Models\AssetAssignment;
use App\Modules\Assets\Models\AssetStatus;
use App\Modules\Organization\Models\Employee;

class AssetAssignmentService
{
    public function findAsset(string  $assetId): Asset {
        $asset = Asset::query() ->find($assetId); 
            if (! $asset) {
                throw  AssetAssignmentException::AssetNotFoundException(); 
            }
        return $asset;
    }

    public function findActiveAssignment(Asset $asset): AssetAssignment {
        $assetAssignment = AssetAssignment::query()->where('asset_id', $asset->id)->whereNull('returned_at')->first();
            if (!$assetAssignment) {
                throw AssetAssignmentException::noActiveAssignment();
            }
        return $assetAssignment;
    }

    public function findAssignedStatus(Asset $asset): AssetStatus{
        $assignedStatus = AssetStatus::query()
            ->where('tenant_id', $asset->tenant_id)
            ->where('slug', 'assigned')
            ->first();

        if (! $assignedStatus) {
            throw AssetAssignmentException::AssignedStatusNotFound();
        }
        return $assignedStatus;
    }

    public function findAvailableStatus(Asset $asset): AssetStatus {
        $availableStatus  = AssetStatus::query()
            ->where('tenant_id', $asset->tenant_id)
            ->where('slug', 'available')
            ->first();

        if (!$availableStatus) {
            throw AssetAssignmentException::availableStatusNotFound();
        }
        return $availableStatus;
    }

    public function assertSameTenant(Asset $asset, Employee $employee): void {

        if ($asset->tenant_id !== $employee->tenant_id) {
            throw AssetAssignmentException::CrossTenantAssignmentException();
        }
    }

    public function assertNotAssigned(Asset $asset):void {
        $alreadyAssigned = AssetAssignment::query()
            ->where('asset_id', $asset->id)
            ->whereNull('returned_at')
            ->exists();
        if ($alreadyAssigned) { 
            throw AssetAssignmentException::AssetAlreadyAssignedException(); 
        }
    }

    public function assertDifferentEmployee(Employee $from,Employee $to): void {
        if ($from->is($to)) {
            throw AssetAssignmentException::cannotTransferToSameEmployee();
        }
    }

    public function assignAsset(Asset $asset, Employee $employee, AssetStatus $status): void {
         $asset->update([
             'assigned_employee_id'=> $employee->id,
             'asset_status_id'=> $status->id
         ]);
    }

    public function returnAsset(Asset $asset, AssetStatus $status): void {
         $asset->update([
             'assigned_employee_id'=> NULL,
             'asset_status_id'=> $status->id
         ]);
    }
}
