<?php

namespace App\Modules\Shared\Application\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class BaseResourceCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return $this->collection->map(
            fn ($resource) => $resource
        )->all();
    }
}
