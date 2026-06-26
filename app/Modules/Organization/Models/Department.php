<?php

namespace App\Modules\Organization\Models;

use App\Models\User;
use App\Modules\Shared\Database\Factories\DepartmentFactory;
use App\Modules\Shared\Models\Tenant;
use App\Modules\Shared\Models\TenantModel;;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'tenant_id', 'branch_id', 'name', 'created_by', 'updated_by',
])]
class Department extends TenantModel
{
    use HasFactory;

    public function branch():BelongsTo
    { 
        return $this->belongsTo(Branch::class); 
    } 
    public function positions():HasMany 
    { 
        return $this->hasMany(Position::class); 
    } 
    public function employees() :HasMany
    { 
        return $this->hasMany(Employee::class); 
    } 
    public function creator():BelongsTo 
    { 
        return $this->belongsTo( User::class, 'created_by' ); 
    } 
    public function updater():BelongsTo 
    { 
        return $this->belongsTo( User::class, 'updated_by' );
    }

    protected static function newFactory()
    {
        return DepartmentFactory::new();
    }
}
