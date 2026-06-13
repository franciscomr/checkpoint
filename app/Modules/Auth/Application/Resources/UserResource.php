<?php

namespace App\Modules\Auth\Application\Resources;

use Illuminate\Http\Request;
use App\Modules\Shared\Application\Resources\BaseApiResource;

class UserResource extends BaseApiResource
{
    protected function data(Request $request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'avatar_url' => $this->avatar_url,
            'is_active' => $this->is_active,
            'roles' => $this->whenLoaded(
                'roles',
                fn () => $this->roles
                    ->pluck('slug')
                    ->values()
            ),
        ];
    }
}
