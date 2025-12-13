<?php

namespace App\Modules\Company\Infrastructure\Repositories;

use App\Modules\Company\Domain\Models\Employee;
use App\Modules\Shared\Infrastructure\Repositories\BaseRepository;

class EmployeeRepository extends BaseRepository
{
    protected array $searchable = ['first_name', 'last_name', 'email'];
    protected array $filterable = ['company_position_id', 'branch_id', 'is_active'];
    protected array $sortable = ['first_name', 'last_name', 'created_at'];
    protected array $relations = ['position', 'branch', 'position.department'];

    public function __construct(Employee $model)
    {
        parent::__construct($model);
    }
}
