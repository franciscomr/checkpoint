<?php

namespace App\Modules\Company\Application\Resources;

use App\Modules\Shared\Application\Resources\BaseJsonResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyDepartmentResource extends BaseJsonResource
{
    protected string $resourceType = 'company_department';

    protected function getAttributes(): array
    {
        return [
            'id' => $this->id,
            'company_id' => $this->company_id,
            'department_template_id' => $this->department_template_id,
            'name' => $this->name,
            'created_at' => $this->created_at,
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
            'department_template' => [
                'data' => new DepartmentTemplateResource(
                    $this->whenLoaded('department_template')
                )
            ],
            'company_positions' => [
                'data' => CompanyPositionResource::collection(
                    $this->whenLoaded('company_positions')
                )
            ]
        ];
    }
}
