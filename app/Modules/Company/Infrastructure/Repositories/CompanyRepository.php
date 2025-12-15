<?php

namespace App\Modules\Company\Infrastructure\Repositories;

use App\Modules\Company\Domain\Models\Company;
use App\Modules\Shared\Infrastructure\Repositories\BaseRepository;

class CompanyRepository extends BaseRepository
{
    protected array $searchable = ['name', 'tax_id', 'city','state'];
    protected array $filterable = ['city', 'state', 'is_active'];
    protected array $sortable  = ['name','tax_id', 'created_at'];
    protected array $relations = ['branches', 'departments'];

    public function __construct(Company $model)
    {
        return parent::__construct($model);
    }

        /**
     * GET /companies/{id}/branches
     */
    public function getBranches(int $companyId, array $queryParams = [], ?int $perPage = null)
    {
        $perPage = $perPage ?? env('API_DEFAULT_PER_PAGE', 10);
        $company = $this->find($companyId);

        $query = $company->branches();

        if (!empty($queryParams['search'])) {
            $search = $queryParams['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        if (!empty($queryParams['filter'])) {
            foreach ($queryParams['filter'] as $field => $value) {
                if (in_array($field, ['is_active', 'city', 'state'])) {
                    $query->where($field, $value);
                }
            }
        }

        if (!empty($queryParams['sort'])) {
            $field = ltrim($queryParams['sort'], '-');
            $direction = str_starts_with($queryParams['sort'], '-') ? 'desc' : 'asc';

            if (in_array($field, ['name', 'created_at'])) {
                $query->orderBy($field, $direction);
            }
        }

        return $query->paginate($perPage);
    }
}
