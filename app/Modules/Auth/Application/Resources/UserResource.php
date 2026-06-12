<?php

namespace App\Modules\Auth\Application\Resources;

use Illuminate\Http\Request;
use App\Modules\Shared\Application\Resources\BaseApiResource;

class UserResource extends BaseApiResource
{
    protected function resourceAttributes(): array
    {
        return [
            'id' => $this->id,
            'tenant_id' => $this->tenant_id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar_url' => $this->avatar_url,
            'is_active' => $this->is_active,
        ];
    }
}
