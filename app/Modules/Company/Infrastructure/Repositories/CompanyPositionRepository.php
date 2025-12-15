<?php

namespace App\Modules\Company\Infrastructure\Repositories;

use App\Modules\Company\Domain\Models\CompanyPosition;
use App\Modules\Shared\Infrastructure\Repositories\BaseRepository;

class CompanyPositionRepository extends BaseRepository
{
    protected array $searchable = ['name'];
    protected array $filterable = ['company_department_id', 'position_template_id', 'is_active'];
    protected array $sortable = ['name', 'created_at'];
    protected array $relations = ['company', 'company_department','position_template','employees'];

    public function __construct(CompanyPosition $model)
    {
        parent::__construct($model);
    }
}
