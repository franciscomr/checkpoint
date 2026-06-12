<?php

namespace App\Modules\Shared\Application\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

final class ApiResponse
{
    public static function success(
        mixed $data = null,
        string $message = 'Success',
        int $status = 200,
        array $meta = []
    ): JsonResponse {

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => self::transformData($data),
            'meta' => empty($meta) ? null : $meta,
        ], $status);
    }

    public static function created(
        mixed $data = null,
        string $message = 'Resource created successfully'
    ): JsonResponse {

        return self::success(
            data: $data,
            message: $message,
            status: 201
        );
    }

    public static function updated(
        mixed $data = null,
        string $message = 'Resource updated successfully'
    ): JsonResponse {

        return self::success(
            data: $data,
            message: $message
        );
    }

    public static function deleted(
        string $message = 'Resource deleted successfully'
    ): JsonResponse {

        return self::success(
            data: null,
            message: $message
        );
    }

    public static function paginated(
        LengthAwarePaginator $paginator,
        ResourceCollection $resource,
        string $message = 'Resources retrieved successfully'
    ): JsonResponse {

        return self::success(
            data: $resource->resolve(),

            message: $message,

            meta: [
                'pagination' => ApiPagination::make(
                    $paginator
                ),
            ]
        );
    }

    protected static function transformData(
        mixed $data
    ): mixed {

        if (
            $data instanceof JsonResource ||
            $data instanceof ResourceCollection
        ) {
            return $data->resolve();
        }

        if ($data instanceof Arrayable) {
            return $data->toArray();
        }

        return $data;
    }
}
