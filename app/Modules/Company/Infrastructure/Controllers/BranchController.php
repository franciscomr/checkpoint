<?php

namespace App\Modules\Company\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Company\Application\Request\BranchRequest;
use App\Modules\Company\Application\Resources\BranchResource;
use App\Modules\Company\Application\Resources\BranchCollection;
use App\Modules\Company\Domain\Models\Branch;
use App\Modules\Company\Infrastructure\Repositories\BranchRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BranchController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private BranchRepository $repository) {}

    public function index()
    {
        $this->authorize('viewAny', Branch::class);
        $branches = $this->repository->all(request()->query());
        return new BranchCollection($branches);
    }

    public function store(BranchRequest $request)
    {
        $companyId = $request->input('company_id');
        $this->authorize('create', [Branch::class, $companyId]);
        $branch = $this->repository->create($request->validated());
        return new BranchResource($branch);
    }

    public function show(int $id, Request $request)
    {
        $includes = $request->query('include', '');
        $includes = $includes ? explode(',', $includes) : [];

        $branch = $this->repository->find($id, $includes);
        $this->authorize('view', $branch);
        return new BranchResource($branch);
    }

    public function update(BranchRequest $request, int $id)
    {
        $branch = $this->repository->find($id);
        $this->authorize('update', $branch);

        $branch = $this->repository->update($request->validated(), $id);
        return new BranchResource($branch);
    }

    public function destroy(int $id)
    {
        $branch = $this->repository->find($id);
        $this->authorize('delete', $branch);

        $this->repository->delete($id);
        return response()->json(['message' => 'Branch deleted']);
    }
}
