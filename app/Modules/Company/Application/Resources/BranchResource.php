<?php

namespace App\Modules\Company\Application\Resources;

use App\Modules\Shared\Application\Resources\BaseJsonResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Company\Application\Resources\CompanyResource;

class BranchResource extends BaseJsonResource
{
    protected string $resourceType = 'branch';

    protected function getAttributes(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
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
            'company' => [
                'data' => new CompanyResource(
                    $this->whenLoaded('company')
                )
            ],
            'employees' => [
                'data' => EmployeeResource::collection(
                    $this->whenLoaded('employees')
                )
            ]
        ];
    }
}
