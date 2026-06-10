<?php

namespace App\Modules\Shared\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class TenantScope implements Scope
{
    public function apply( Builder $builder, Model $model): void 
    {
        $tenantId = tenant_id();

        if (!$tenantId) {
            return;
        }

        $builder->where(
            $model->getTable() . '.tenant_id',
            $tenantId
        );
    }
}
