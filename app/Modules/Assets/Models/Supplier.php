<?php

namespace App\Modules\Assets\Models;

use App\Modules\Shared\Database\Factories\SupplierFactory;
use App\Modules\Shared\Models\TenantModel;
use App\Modules\Shared\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'tenant_id',
    'name',
    'contact_name',
    'email',
    'phone',
    'notes',
])]
class Supplier extends TenantModel
{
    use HasFactory;
    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    protected static function newFactory() {
        return SupplierFactory::new();
    }
}
