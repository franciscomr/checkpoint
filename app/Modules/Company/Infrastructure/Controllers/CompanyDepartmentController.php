<?php

namespace App\Modules\Company\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Company\Application\Request\CompanyDepartmentRequest;
use App\Modules\Company\Application\Resources\CompanyDepartmentCollection;
use App\Modules\Company\Application\Resources\CompanyDepartmentResource;
use App\Modules\Company\Domain\Models\CompanyDepartment;
use App\Modules\Company\Infrastructure\Repositories\CompanyDepartmentRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CompanyDepartmentController extends Controller
{
    use AuthorizesRequests;
    protected $repository;

    public function __construct(CompanyDepartmentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', CompanyDepartment::class);

        $company_departments = $this->repository->all($request->all(), $request->input('perPage'));
        return new CompanyDepartmentCollection($company_departments);
    }

    public function store(CompanyDepartmentRequest $request)
    {
        $companyId = $request->input('company_id');
        $this->authorize('create', [CompanyDepartment::class, $companyId]);

        $company_department = $this->repository->create($request->validated());
        return new CompanyDepartmentResource($company_department);
    }

    public function show(int $id, Request $request)
    {
        $includes = $request->query('include', '');
        $includes = $includes ? explode(',', $includes) : [];

        $company_department = $this->repository->find($id, $includes);
        $this->authorize('view', $company_department);

        return new CompanyDepartmentResource($company_department);
    }

    public function update(CompanyDepartmentRequest $request, int $id)
    {
        $companyDepartmentModel = $this->repository->find($id);
        $this->authorize('update', $companyDepartmentModel);

        $company_department = $this->repository->update($request->validated(), $id);
        return new CompanyDepartmentResource($company_department);
    }

    public function destroy(int $id)
    {
        $companyDepartmentModel = $this->repository->find($id);
        $this->authorize('delete', $companyDepartmentModel);

        $this->repository->delete($id);
        return response()->json(['message' => 'Company_department deleted']);
    }
}
