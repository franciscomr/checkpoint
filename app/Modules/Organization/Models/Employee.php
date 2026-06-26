<?php

namespace App\Modules\Organization\Models;

use App\Models\User;
use App\Modules\Assets\Models\AssetAssignment;
use App\Modules\Shared\Database\Factories\EmployeeFactory;
use App\Modules\Shared\Models\Tenant;
use App\Modules\Shared\Models\TenantModel;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'tenant_id', 'first_name', 'last_name', 'employee_code', 'branch_id', 'department_id', 'position_id', 'is_active','email','phone','hire_date', 'created_by', 'updated_by',
])]
class Employee extends TenantModel
{
    use HasFactory, HasUlids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected function casts(): array 
    { 
        return [ 'is_active' => 'boolean', ]; 
    } 
    protected $appends = [ 'full_name', ]; 
    public function getFullNameAttribute(): string { 
        return trim( "{$this->first_name} {$this->last_name}" ); 
    } 
        
    public function branch() 
    { 
        return $this->belongsTo(Branch::class); 
    } 
    public function department():BelongsTo 
    { 
        return $this->belongsTo(Department::class); 
    } 
    public function position():BelongsTo 
    { 
        return $this->belongsTo(Position::class); 
    } 
    public function assignments():HasMany 
    { 
        return $this->hasMany( AssetAssignment::class ); 
    } 
    public function activeAssignments() 
    { 
        return $this->assignments() ->whereNull('returned_at'); 
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
        return EmployeeFactory::new();
    }
}
