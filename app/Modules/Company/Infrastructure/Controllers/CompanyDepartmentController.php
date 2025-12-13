<?php

namespace App\Modules\Company\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Company\Application\Request\CompanyDepartmentRequest;
use App\Modules\Company\Application\Resources\CompanyDepartmentCollection;
use App\Modules\Company\Application\Resources\CompanyDepartmentResource;
use App\Modules\Company\Infrastructure\Repositories\CompanyDepartmentRepository;
use Illuminate\Http\Request;

class CompanyDepartmentController extends Controller
{
    protected $repository;

    public function __construct(CompanyDepartmentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request) 
    {
        $company_departments = $this->repository->all($request->all(), $request->input('perPage'));
        return new CompanyDepartmentCollection($company_departments);
    }

    public function store(CompanyDepartmentRequest $request)
    {
        $company_department = $this->repository->create($request->validated());
        return new CompanyDepartmentResource($company_department);
    }

    public function show(int $id, Request $request)
    {
        $includes = $request->query('include', '');
        $includes = $includes ? explode(',', $includes) : [];

        $company_department = $this->repository->find($id, $includes);
        return new CompanyDepartmentResource($company_department);
    }

    public function update(CompanyDepartmentRequest $request, int $id)
    {
        $company_department = $this->repository->update($request->validated(), $id);
        return new CompanyDepartmentResource($company_department);
    }

    public function destroy(int $id)
    {
        $this->repository->delete($id);
        return response()->json(['message' => 'Company_department deleted']);
    }
}
