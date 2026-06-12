<?php

namespace App\Modules\Shared\Application\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
abstract class BaseApiResource extends JsonResource
{
    abstract protected function resourceAttributes(): array;

    public function toArray(Request $request): array
    {
        return $this->resourceAttributes();
    }
}
