<?php

namespace App\Modules\Assets\Models;

use App\Models\User;
use App\Modules\Organization\Models\Employee;
use App\Modules\Shared\Database\Factories\AssetAssignmentFactory;

use App\Modules\Shared\Models\Tenant;
use App\Modules\Shared\Models\TenantModel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
        'tenant_id',
        'asset_id',
        'employee_id',
        'assigned_at',
        'expected_return_at',
        'returned_at',
        'assignment_notes',
        'return_notes',
        'created_by',
        'updated_by',
])]
class AssetAssignment extends TenantModel
{
    use HasUlids, HasFactory;

     protected $table = 'asset_assignments';

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'expected_return_at' => 'datetime',
            'returned_at' => 'datetime',
        ];
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function creator()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function updater()
    {
        return $this->belongsTo(
            User::class,
            'updated_by'
        );
    }

    public function isActive(): bool
    {
        return $this->returned_at === null;
    }

        protected static function newFactory()
    {
        return AssetAssignmentFactory::new();
    }
}
