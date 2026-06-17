<?php

namespace App\Modules\Shared\Application\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
abstract class BaseApiResource extends JsonResource
{
    abstract protected function data(): array;

    public function toArray(Request $request): array
    {
        return array_merge(
            ['id' => (string) $this->id],
            $this->data()
        );
    }
}
