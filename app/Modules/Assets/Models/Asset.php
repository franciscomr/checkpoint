<?php

namespace App\Modules\Assets\Models;

use App\Modules\Assets\Enums\AssetCriticality;
use App\Modules\Shared\Database\Factories\AssetFactory;
use App\Modules\Shared\Models\Branch;
use App\Modules\Shared\Models\Department;
use App\Modules\Shared\Models\Employee;
use App\Modules\Shared\Models\TenantModel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'tenant_id',

    'asset_tag',
    'serial_number',
    'name',

    'asset_category_id',
    'asset_model_id',
    'asset_status_id',

    'branch_id',
    'department_id',
    'assigned_employee_id',

    'supplier_id',

    'purchase_date',
    'purchase_cost',
    'invoice_number',

    'depreciation_months',
    'residual_value',

    'warranty_expiration_date',

    'criticality',

    'business_service',

    'notes',
])]
class Asset extends TenantModel
{
    use HasUlids, HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'warranty_expiration_date' => 'date',

            'purchase_cost' => 'decimal:2',
            'residual_value' => 'decimal:2',

            'criticality' => AssetCriticality::class,
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            AssetCategory::class,
            'asset_category_id'
        );
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(
            AssetModel::class,
            'asset_model_id'
        );
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(
            AssetStatus::class,
            'asset_status_id'
        );
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function assignedEmployee(): BelongsTo
    {
        return $this->belongsTo(
            Employee::class,
            'assigned_employee_id'
        );
    }

    /*
    public function documents(): HasMany
    {
        return $this->hasMany(AssetDocument::class);
    }

    public function movements(): HasMany
    {
        return $this->hasMany(AssetMovement::class);
    }

    */

    protected static function newFactory()
    {
        return AssetFactory::new();
    }
}
