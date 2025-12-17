<?php

namespace App\Modules\Auth\Application\Resources;

use App\Modules\Shared\Application\Resources\BaseJsonResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends BaseJsonResource
{
    protected string $resourceType = 'session';

    protected function getAttributes(): array
    {
        return [
            'ip_address' => $this->ip_address,
            'platform' => $this->platform,
            'user_agent' => $this->user_agent,
            'is_suspicious' => $this->is_suspicious,
            'suspicious_reason' => $this->suspicious_reason,
            'logged_in_at' => $this->logged_in_at,
            'last_activity' => $this->last_activity
        ];
    }

    protected function getRelationships(): array
    {
        return [];
    }
}
