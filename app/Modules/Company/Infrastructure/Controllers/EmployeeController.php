<?php

namespace App\Modules\Company\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Company\Application\Request\EmployeeRequest;
use App\Modules\Company\Application\Resources\EmployeeCollection;
use App\Modules\Company\Application\Resources\EmployeeResource;
use App\Modules\Company\Domain\Models\Employee;
use App\Modules\Company\Infrastructure\Repositories\EmployeeRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    use AuthorizesRequests;
    protected $repository;

    public function __construct(EmployeeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Employee::class);
        $employees = $this->repository->all($request->all(), $request->input('perPage'));
        return new EmployeeCollection($employees);
    }

    public function store(EmployeeRequest $request)
    {
        $branchId = $request->input('branch_id');
        $branch = $this->repository->getCompanyForBranch($branchId);

        $this->authorize('create', [
            Employee::class,
            $branch->company_id,
            $branchId,
        ]);

        $employee = $this->repository->create($request->validated());
        return new EmployeeResource($employee);
    }

    public function show(int $id, Request $request)
    {
        $includes = $request->query('include', '');
        $includes = $includes ? explode(',', $includes) : [];

        $employee = $this->repository->find($id, $includes);

        $this->authorize('view', $employee);

        return new EmployeeResource($employee);
    }

    public function update(EmployeeRequest $request, int $id)
    {
        $employee = $this->repository->find($id);
        $this->authorize('update', $employee);

        $employee = $this->repository->update($request->validated(), $id);
        return new EmployeeResource($employee);
    }

    public function destroy(int $id)
    {
        $employee = $this->repository->find($id);
        $this->authorize('delete', $employee);

        $this->repository->delete($id);
        return response()->json(['message' => 'Employee deleted']);
    }
}
