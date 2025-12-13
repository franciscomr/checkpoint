<?php

namespace App\Modules\Company\Infrastructure\Repositories;

use App\Modules\Company\Domain\Models\Department;
use App\Modules\Company\Domain\Models\DepartmentTemplate;
use App\Modules\Shared\Infrastructure\Repositories\BaseRepository;

class DepartmentTemplateRepository extends BaseRepository
{
    protected array $searchable = ['name', 'description'];
    protected array $filterable = ['is_active'];
    protected array $sortable = ['name', 'created_at'];
    protected array $relations = ['positions'];

    public function __construct(DepartmentTemplate $model)
    {
        parent::__construct($model);
    }
}
