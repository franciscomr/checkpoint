<?php

namespace App\Modules\Company\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Company\Application\Request\PositionTemplateRequest;
use App\Modules\Company\Application\Resources\PositionTemplateCollection;
use App\Modules\Company\Application\Resources\PositionTemplateResource;
use App\Modules\Company\Infrastructure\Repositories\PositionTemplateRepository;
use Illuminate\Http\Request;

class PositionTemplateController extends Controller
{
    protected $repository;

    public function __construct(PositionTemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $positions = $this->repository->all(request()->query());
        return new PositionTemplateCollection($positions);
    }

    public function show(int $id, Request $request)
    {
        $includes = $request->query('include', '');
        $includes = $includes ? explode(',', $includes) : [];

        $position = $this->repository->find($id, $includes);
        return new PositionTemplateResource($position);
    }

    public function store(PositionTemplateRequest $request)
    {
        $position = $this->repository->create($request->validated());
        return new PositionTemplateResource($position);
    }

    public function update(PositionTemplateRequest $request, int $id)
    {
        $branch = $this->repository->update($request->validated(),$id);
        return new PositionTemplateResource($branch);
    }

    public function destroy(int $id)
    {
        $this->repository->delete($id);
        return response()->json(['message' => 'Position deleted']);
    }
}
