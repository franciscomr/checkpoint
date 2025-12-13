<?php

namespace App\Modules\Company\Infrastructure\Repositories;

use App\Modules\Company\Domain\Models\Branch;
use App\Modules\Shared\Infrastructure\Repositories\BaseRepository;

class BranchRepository extends BaseRepository
{
    protected array $searchable = ['name', 'city', 'state'];
    protected array $filterable = ['is_active', 'company_id'];
    protected array $sortable  = ['name', 'created_at'];
    protected array $relations = ['company'];

    public function __construct(Branch $model)
    {
        return parent::__construct($model);
    }
    
}
