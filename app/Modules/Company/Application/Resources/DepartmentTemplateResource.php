<?php

namespace App\Modules\Company\Application\Resources;

use App\Modules\Shared\Application\Resources\BaseJsonResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentTemplateResource extends BaseJsonResource
{
    protected string $resourceType = 'department_template';

    protected function getAttributes(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
        ];
    }

    protected function getRelationships(): array
    {
        return [
            'company_departments' => [
                'data' => CompanyDepartmentResource::collection(
                    $this->whenLoaded('company_departments')
                )
            ]
        ];
    }
}
