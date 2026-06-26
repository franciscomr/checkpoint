<?php

namespace App\Modules\Assets\Models;

use App\Modules\Shared\Database\Factories\AssetModelFactory;
use App\Modules\Shared\Models\TenantModel;
use App\Modules\Shared\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'tenant_id',
    'asset_category_id',
    'brand',
    'name',
    'manufacturer_part_number',
    'description',
])]
class AssetModel extends TenantModel
{
    use HasFactory;
    public function category(): BelongsTo
    {
        return $this->belongsTo(
            AssetCategory::class,
            'asset_category_id'
        );
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    protected static function newFactory()
    {
        return AssetModelFactory::new();
    }
}
