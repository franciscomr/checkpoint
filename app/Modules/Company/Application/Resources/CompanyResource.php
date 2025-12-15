<?php

namespace App\Modules\Company\Application\Resources;

use App\Modules\Shared\Application\Resources\BaseJsonResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Company\Application\Resources\BranchResource;

class CompanyResource extends BaseJsonResource
{
    protected string $resourceType = 'company';

    protected function getAttributes(): array
    {
        return [
            'name' => $this->name,
            'tax_id' => $this->tax_id,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postal_code,
            'is_active' => (bool) $this->is_active,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
 
    protected function getRelationships(): array
    {
        return [
            'branches' => [
                'data' => BranchResource::collection(
                    $this->whenLoaded('branches')
                )
            ],
            'departments' => [
                'data' => CompanyDepartmentResource::collection(
                    $this->whenLoaded('departments')
                )
            ]
        ];
    }
}
