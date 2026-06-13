<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Application\Resources\UserResource;
use App\Modules\Shared\Application\Http\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MeController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user()
            ->load('roles');

        return ApiResponse::success(
            data: new UserResource($user),
            message: 'Authenticated user retrieved successfully'
        );
    }
}
