<?php

namespace App\Modules\Assets\Models;

use App\Modules\Shared\Database\Factories\AssetStatusFactory;
use App\Modules\Shared\Models\TenantModel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'tenant_id',
    'name',
    'slug',
    'color',
    'is_assignable',
    'sort_order',
])]
class AssetStatus extends TenantModel
{
    use HasFactory;

    public const AVAILABLE = 'available';

    public const ASSIGNED = 'assigned';

    public const MAINTENANCE = 'maintenance';

    public const RETIRED = 'retired';

    protected function casts(): array
    {
        return [
            'is_assignable' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    protected static function newFactory(){
        return AssetStatusFactory::new();
    }
}
