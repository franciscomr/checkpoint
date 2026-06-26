<?php

namespace App\Modules\Organization\Models;

use App\Models\User;
use App\Modules\Shared\Database\Factories\BranchFactory;
use App\Modules\Shared\Models\Tenant;
use App\Modules\Shared\Models\TenantModel;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'tenant_id', 'name', 'address', 'city', 'state', 'postal_code', 'is_active', 'created_by', 'updated_by',
])]
class Branch extends TenantModel
{
    use HasFactory;

    protected function casts(): array 
    { 
        return [ 'is_active' => 'boolean', ]; 
    }

    public function departments(): HasMany
    { 
        return $this->hasMany(Department::class); 
    }

    public function employees(): HasMany
    { 
        return $this->hasMany(Employee::class); 
    }

    public function creator(): BelongsTo
    { 
        return $this->belongsTo( User::class, 'created_by' ); 
    } 
    public function updater(): BelongsTo
    { 
        return $this->belongsTo( User::class, 'updated_by' );
    }

    protected static function newFactory()
    {
        return BranchFactory::new();
    }
}
