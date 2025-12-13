<?php

namespace App\Modules\Company\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Company\Application\Request\EmployeeRequest;
use App\Modules\Company\Application\Resources\EmployeeCollection;
use App\Modules\Company\Application\Resources\EmployeeResource;
use App\Modules\Company\Infrastructure\Repositories\EmployeeRepository;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $repository;

    public function __construct(EmployeeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request) 
    {
        $employees = $this->repository->all($request->all(), $request->input('perPage'));
        return new EmployeeCollection($employees);
    }

    public function store(EmployeeRequest $request)
    {
        $employee = $this->repository->create($request->validated());
        return new EmployeeResource($employee);
    }

    public function show(int $id, Request $request)
    {
        $includes = $request->query('include', '');
        $includes = $includes ? explode(',', $includes) : [];

        $employee = $this->repository->find($id, $includes);
        return new EmployeeResource($employee);
    }

    public function update(EmployeeRequest $request, int $id)
    {
        $employee = $this->repository->update($request->validated(), $id);
        return new EmployeeResource($employee);
    }

    public function destroy(int $id)
    {
        $this->repository->delete($id);
        return response()->json(['message' => 'Employee deleted']);
    }
}
