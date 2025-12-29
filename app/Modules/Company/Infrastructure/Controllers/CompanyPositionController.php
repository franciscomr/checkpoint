<?php

namespace App\Modules\Company\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Company\Application\Request\CompanyPositionRequest;
use App\Modules\Company\Application\Resources\CompanyPositionCollection;
use App\Modules\Company\Application\Resources\CompanyPositionResource;
use App\Modules\Company\Domain\Models\CompanyPosition;
use App\Modules\Company\Infrastructure\Repositories\CompanyPositionRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CompanyPositionController extends Controller
{
    use AuthorizesRequests;
    protected $repository;

    public function __construct(CompanyPositionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', CompanyPosition::class);

        $company_positions = $this->repository->all($request->all(), $request->input('perPage'));
        return new CompanyPositionCollection($company_positions);
    }

    public function store(CompanyPositionRequest $request)
    {
        $companyId = $request->input('company_id');
        $this->authorize('create', [CompanyPosition::class, $companyId]);

        $company_position = $this->repository->create($request->validated());
        return new CompanyPositionResource($company_position);
    }

    public function show(int $id, Request $request)
    {
        $includes = $request->query('include', '');
        $includes = $includes ? explode(',', $includes) : [];

        $company_position = $this->repository->find($id, $includes);
        $this->authorize('view', $company_position);

        return new CompanyPositionResource($company_position);
    }

    public function update(CompanyPositionRequest $request, int $id)
    {
        $companyPoisitionModel = $this->repository->find($id);
        $this->authorize('update', $companyPoisitionModel);

        $company_position = $this->repository->update($request->validated(), $id);
        return new CompanyPositionResource($company_position);
    }

    public function destroy(int $id)
    {
        $companyPoisitionModel = $this->repository->find($id);
        $this->authorize('delete', $companyPoisitionModel);

        $this->repository->delete($id);
        return response()->json(['message' => 'Company deleted']);
    }
}
