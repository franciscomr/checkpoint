<?php

namespace App\Modules\Company\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Company\Application\Request\DepartmentTemplateRequest;
use App\Modules\Company\Application\Resources\DepartmentTemplateCollection;
use App\Modules\Company\Application\Resources\DepartmentTemplateResource;
use App\Modules\Company\Infrastructure\Repositories\DepartmentTemplateRepository;
use Illuminate\Http\Request;

class DepartmentTemplateController extends Controller
{
    protected $repository;

    public function __construct(DepartmentTemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request) 
    {
        $departments = $this->repository->all($request->all(), $request->input('perPage'));
        return new DepartmentTemplateCollection($departments);
    }

    public function store(DepartmentTemplateRequest $request)
    {
        $department = $this->repository->create($request->validated());
        return new DepartmentTemplateResource($department);
    }

    public function show(int $id, Request $request)
    {
        $includes = $request->query('include', '');
        $includes = $includes ? explode(',', $includes) : [];

        $department = $this->repository->find($id, $includes);
        return new DepartmentTemplateResource($department);
    }

    public function update(DepartmentTemplateRequest $request, int $id)
    {
        $department = $this->repository->update($request->validated(), $id);
        return new DepartmentTemplateResource($department);
    }

    public function destroy(int $id)
    {
        $this->repository->delete($id);
        return response()->json(['message' => 'Depretment deleted']);
    }

}
