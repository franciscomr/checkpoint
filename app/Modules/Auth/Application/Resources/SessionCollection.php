<?php

namespace App\Modules\Auth\Application\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SessionCollection extends ResourceCollection
{
    public $collects = SessionResource::class;


    public function toArray(Request $request): array
    {
        return [
            'data' => SessionResource::collection($this->collection),
            'meta' => [
                'total' => $this->collection->count(),
            ],
        ];
    }

}
