<?php

namespace App\Modules\Company\Infrastructure\Repositories;

use App\Modules\Company\Domain\Models\DepartmentTemplate;
use App\Modules\Shared\Infrastructure\Repositories\BaseRepository;

class DepartmentTemplateRepository extends BaseRepository
{
    protected array $searchable = ['name', 'description'];
    protected array $filterable = ['name'];
    protected array $sortable = ['name', 'created_at'];
    protected array $relations = ['company_departments'];

    public function __construct(DepartmentTemplate $model)
    {
        parent::__construct($model);
    }
}
