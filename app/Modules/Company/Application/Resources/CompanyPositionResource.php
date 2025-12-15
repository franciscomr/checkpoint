<?php

namespace App\Modules\Company\Application\Resources;

use App\Modules\Shared\Application\Resources\BaseJsonResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyPositionResource extends BaseJsonResource
{
    protected string $resourceType = 'company_position';


    protected function getAttributes(): array
    {
        return [
            'id' => $this->id,
            'company_id' => $this->company_id,
            'position_template_id' => $this->position_template_id,
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
            'company_department' => [
                'data' => new CompanyDepartmentResource(
                    $this->whenLoaded('company_department')
                )
            ],
            'position_template' => [
                'data' => new PositionTemplateResource(
                    $this->whenLoaded('position_template')
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
