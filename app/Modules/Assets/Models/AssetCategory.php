<?php

namespace App\Modules\Assets\Models;

use App\Modules\Shared\Database\Factories\AssetCategoryFactory;
use App\Modules\Shared\Models\TenantModel;
use App\Modules\Shared\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'tenant_id',
    'parent_id',
    'name',
    'slug',
    'description',
])]
class AssetCategory extends TenantModel
{
    use HasFactory;

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function assetModels(): HasMany
    {
        return $this->hasMany(AssetModel::class);
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    protected static function newFactory()
    {
    return AssetCategoryFactory::new();
    }
}
