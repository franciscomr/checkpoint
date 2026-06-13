<?php

namespace App\Modules\Shared\Application\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
abstract class BaseApiResource extends JsonResource
{
    abstract protected function data(Request $request): array;

    public function toArray(Request $request): array
    {
        return array_merge(
            ['id' => $this->id],
            $this->data($request)
        );
    }
}
