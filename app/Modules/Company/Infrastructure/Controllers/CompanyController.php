<?php

namespace App\Modules\Company\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Company\Infrastructure\Repositories\CompanyRepository;
use App\Modules\Company\Application\Request\CompanyRequest;
use App\Modules\Company\Application\Resources\CompanyResource;
use App\Modules\Company\Application\Resources\CompanyCollection;
use App\Modules\Company\Application\Resources\BranchCollection;
use App\Modules\Company\Domain\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected $repository;

    public function __construct(CompanyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request) 
    {
        $companies = $this->repository->all($request->all(), $request->input('perPage'));
        return new CompanyCollection($companies);
    }

    public function store(CompanyRequest $request)
    {
        $company = $this->repository->create($request->validated());
        return new CompanyResource($company);
    }

    public function show(int $id, Request $request)
    {
        $includes = $request->query('include', '');
        $includes = $includes ? explode(',', $includes) : [];

        $company = $this->repository->find($id, $includes);
        return new CompanyResource($company);
    }

    public function update(CompanyRequest $request, int $id)
    {
        $company = $this->repository->update($request->validated(), $id);
        return new CompanyResource($company);
    }

    public function destroy(int $id)
    {
        $this->repository->delete($id);
        return response()->json(['message' => 'Company deleted']);
    }

    public function branches(int $id)
    {
        $branches = $this->repository->getBranches($id);
        return new BranchCollection($branches);
    }
}
