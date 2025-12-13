<?php

namespace App\Modules\Company\Application\Resources;

use App\Modules\Shared\Application\Resources\BaseJsonResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyDepartmentResource extends BaseJsonResource
{
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
            'template' => [
                'data' => DepartmentTemplateResource::collection(
                    $this->whenLoaded('template')
                )
            ]
        ];
    }
}
