<?php

namespace App\Modules\Assets\Models;

use App\Models\User;
use App\Modules\Assets\Enums\AssetMovementType;
use App\Modules\Organization\Models\Employee;
use App\Modules\Shared\Database\Factories\AssetMovementFactory;
use App\Modules\Shared\Models\TenantModel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
        'tenant_id',
        'asset_id',
        'movement_type',
        'from_employee_id',
        'to_employee_id',
        'from_status_id',
        'to_status_id',
        'notes',
        'created_by', 
        'performed_at',
        'movement_notes'
])]
class AssetMovement extends TenantModel
{
    use HasUlids, HasFactory;
    public $timestamps = true; // mantiene soporte de timestamps
    const UPDATED_AT = null;
    protected $table = 'asset_movements';


    protected function casts(): array
    {
        return [
            'movement_type' => AssetMovementType::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function fromEmployee(): BelongsTo
    {
        return $this->belongsTo(
            Employee::class,
            'from_employee_id'
        );
    }

    public function toEmployee(): BelongsTo
    {
        return $this->belongsTo(
            Employee::class,
            'to_employee_id'
        );
    }

    public function fromStatus(): BelongsTo
    {
        return $this->belongsTo(
            AssetStatus::class,
            'from_status_id'
        );
    }

    public function toStatus(): BelongsTo
    {
        return $this->belongsTo(
            AssetStatus::class,
            'to_status_id'
        );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

protected static function newFactory()
    {
        return AssetMovementFactory::new();
    }
}
