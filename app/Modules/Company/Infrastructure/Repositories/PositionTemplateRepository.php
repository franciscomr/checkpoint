<?php

namespace App\Modules\Company\Infrastructure\Repositories;

use App\Modules\Company\Domain\Models\PositionTemplate;
use App\Modules\Shared\Infrastructure\Repositories\BaseRepository;

class PositionTemplateRepository extends BaseRepository
{
    protected array $searchable = ['name'];
    protected array $filterable = ['name'];
    protected array $sortable = ['name'];
    protected array $relations = ['company_positions'];

    public function __construct(PositionTemplate $model)
    {
        parent::__construct($model);
    }
}
