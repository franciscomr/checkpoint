<?php

namespace App\Modules\Shared\Traits;

use App\Modules\Shared\Models\Tenant;
use App\Modules\Shared\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
trait BelongsToTenant
{
    protected static function bootBelongsToTenant(): void
    {
        static::addGlobalScope(
            new TenantScope()
        );

        static::creating(function ($model) {

            if (empty($model->tenant_id) && tenant_id()) 
            {
                $model->tenant_id = tenant_id();
            }
        });
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
