<?php

namespace App\Modules\Company\Application\Resources;

use App\Modules\Shared\Application\Resources\BaseJsonResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends BaseJsonResource
{
    protected function getAttributes(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'employee_code' => $this->employee_code,
            'email' => $this->email,
            'photo' => $this->photo,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    protected function getRelationships(): array
    {
        return [
            'branch' => [
                'data' => BranchResource::collection(
                    $this->whenLoaded('branch')
                )
                ],
            'position' => [
                'data' => CompanyPositionResource::collection(
                    $this->whenLoaded('position')
                )
            ]
        ];
    }
}
