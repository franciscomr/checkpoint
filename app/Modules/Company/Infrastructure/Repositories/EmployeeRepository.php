<?php

namespace App\Modules\Company\Infrastructure\Repositories;

use App\Modules\Company\Domain\Models\Employee;
use App\Modules\Shared\Infrastructure\Repositories\BaseRepository;

class EmployeeRepository extends BaseRepository
{
    protected array $searchable = ['first_name', 'last_name', 'email'];
    protected array $filterable = ['company_position_id', 'branch_id', 'is_active'];
    protected array $sortable = ['first_name', 'last_name', 'created_at'];
    protected array $relations = ['company_position', 'branch'];

    public function __construct(Employee $model)
    {
        parent::__construct($model);
    }

    public function getCompanyForBranch(int $branchId)
    {
        $query = $this->model->withTrashed();
        return $query->join('branches', 'employees.branch_id', '=', 'branches.id')
            ->select('branches.company_id')
            ->where('employees.branch_id', $branchId)->first();
    }
}
