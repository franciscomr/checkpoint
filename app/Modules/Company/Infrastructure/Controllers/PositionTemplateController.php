<?php

namespace App\Modules\Company\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Company\Application\Request\PositionTemplateRequest;
use App\Modules\Company\Application\Resources\PositionTemplateCollection;
use App\Modules\Company\Application\Resources\PositionTemplateResource;
use App\Modules\Company\Domain\Models\PositionTemplate;
use App\Modules\Company\Infrastructure\Repositories\PositionTemplateRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PositionTemplateController extends Controller
{
    use AuthorizesRequests;
    protected $repository;

    public function __construct(PositionTemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $this->authorize('viewAny', PositionTemplate::class);

        $positions = $this->repository->all(request()->query());
        return new PositionTemplateCollection($positions);
    }

    public function store(PositionTemplateRequest $request)
    {
        $this->authorize('create', PositionTemplate::class);

        $position = $this->repository->create($request->validated());
        return new PositionTemplateResource($position);
    }

    public function show(int $id, Request $request)
    {
        $this->authorize('view', PositionTemplate::class);

        $includes = $request->query('include', '');
        $includes = $includes ? explode(',', $includes) : [];

        $position = $this->repository->find($id, $includes);
        return new PositionTemplateResource($position);
    }

    public function update(PositionTemplateRequest $request, int $id)
    {
        $this->authorize('update', PositionTemplate::class);

        $position = $this->repository->update($request->validated(), $id);
        return new PositionTemplateResource($position);
    }

    public function destroy(int $id)
    {
        $this->authorize('delete', PositionTemplate::class);

        $this->repository->delete($id);
        return response()->json(['message' => 'Position deleted']);
    }
}
