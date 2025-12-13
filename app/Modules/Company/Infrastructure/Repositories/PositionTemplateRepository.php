<?php

namespace App\Modules\Company\Infrastructure\Repositories;

use App\Modules\Company\Domain\Models\PositionTemplate;
use App\Modules\Shared\Infrastructure\Repositories\BaseRepository;

class PositionTemplateRepository extends BaseRepository
{
    protected array $searchable = ['name'];
    protected array $filterable = ['department_template_id', 'is_active'];
    protected array $sortable = ['name'];
    protected array $relations = ['department'];

    public function __construct(PositionTemplate $model)
    {
        parent::__construct($model);
    }
}
