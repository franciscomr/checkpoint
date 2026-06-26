<?php

namespace App\Modules\Organization\Models;

use App\Models\User;
use App\Modules\Shared\Database\Factories\PositionFactory;
use App\Modules\Shared\Models\Tenant;
use App\Modules\Shared\Models\TenantModel;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'tenant_id', 'department_id', 'name', 'created_by', 'updated_by',
])]
class Position extends TenantModel
{
    use HasFactory;

    public function department():BelongsTo 
    { 
        return $this->belongsTo(Department::class); 
    } 
    public function employees() 
    { 
        return $this->hasMany(Employee::class); 
    } 
    public function creator() 
    { 
        return $this->belongsTo( User::class, 'created_by' ); 
    } 
    public function updater() 
    { 
        return $this->belongsTo( User::class, 'updated_by' );
    }

    protected static function newFactory()
    {
        return PositionFactory::new();
    }
}
