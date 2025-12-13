<?php

namespace App\Modules\Company\Infrastructure\Repositories;

use App\Modules\Company\Domain\Models\CompanyDepartment;
use App\Modules\Shared\Infrastructure\Repositories\BaseRepository;

class CompanyDepartmentRepository extends BaseRepository
{
    protected array $searchable = ['name'];
    protected array $filterable = ['company_id', 'department_template_id', 'is_active'];
    protected array $sortable = ['name', 'created_at'];
    protected array $relations = ['template', 'positions', 'company'];

    public function __construct(CompanyDepartment $model)
    {
        parent::__construct($model);
    }

    public function getPositions(int $companyDepartmentId)
    {
        return $this->find($companyDepartmentId, ['positions'])->positions;
    }
}
