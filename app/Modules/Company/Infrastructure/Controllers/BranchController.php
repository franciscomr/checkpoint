<?php

namespace App\Modules\Company\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Company\Application\Request\BranchRequest;
use App\Modules\Company\Application\Resources\BranchResource;
use App\Modules\Company\Application\Resources\BranchCollection;
use App\Modules\Company\Infrastructure\Repositories\BranchRepository;

class BranchController extends Controller
{
    public function __construct(private BranchRepository $repository)
    {
       
    }

    public function index()
    {
        $branches = $this->repository->all(request()->query());
        return new BranchCollection($branches);
    }

    public function show1(int $id, Request $request)
    {
        $includes = $request->query('include', '');
        $includes = $includes ? explode(',', $includes) : [];

        $branch = $this->repository->find($id, $includes);
        return new BranchResource($branch);
    }

        public function show(int $id, Request $request)
    {
        $includes = $request->query('include', '');
        $includes = $includes ? explode(',', $includes) : [];

        $branch = $this->repository->find($id, $includes);
        return new BranchResource($branch);
    }

    public function store(BranchRequest $request)
    {
        $branch = $this->repository->create($request->validated());
        return new BranchResource($branch);
    }

    public function update(BranchRequest $request, int $id)
    {
        $branch = $this->repository->update($request->validated(),$id);
        return new BranchResource($branch);
    }

    public function destroy(int $id)
    {
        $this->repository->delete($id);
        return response()->json(['message' => 'Branch deleted']);
    }
}
