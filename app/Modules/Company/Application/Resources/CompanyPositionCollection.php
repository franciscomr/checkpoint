<?php

namespace App\Modules\Company\Application\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyPositionCollection extends ResourceCollection
{
    protected string $resourceType = 'company_position';

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => CompanyPositionResource::collection($this->collection),
        ];
    }

    public function with(Request $request): array
    {
        return [
            'meta' => [
                'current_page' => $this->currentPage(),
                'per_page'     => $this->perPage(),
                'total'        => $this->total(),
            ],
            'links' => [
                'first' => $this->url(1),
                'prev'  => $this->previousPageUrl(),
                'next'  => $this->nextPageUrl(),
                'last'  => $this->url($this->lastPage()),
            ],
        ];
    }
}
