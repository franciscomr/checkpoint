<?php

namespace App\Modules\Assets\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Assets\Actions\CreateAssetAction;
use App\Modules\Assets\Requests\CreateAssetRequest;
use App\Modules\Assets\Resources\AssetResource;
use App\Modules\Shared\Application\Http\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function __construct(
        protected CreateAssetAction $createAssetAction
    ) {}

    public function store(CreateAssetRequest $request): JsonResponse {
        $asset = $this->createAssetAction
            ->execute($request->toDto());

        return ApiResponse::created(
            data: new AssetResource($asset),
            message: 'Asset created successfully'
        );
    }
}
