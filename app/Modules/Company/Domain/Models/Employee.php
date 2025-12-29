<?php

namespace App\Modules\Company\Domain\Models;

use App\Models\User;
use App\Modules\Authorization\Domain\Models\Role;
use App\Modules\Shared\Infrastructure\Traits\AssignAuditFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Employee extends Model
{
    use HasFactory, SoftDeletes, AssignAuditFields;

    protected $fillable = [
        'branch_id',
        'company_position_id',
        'first_name',
        'last_name',
        'employee_code',
        'email',
        'photo_path',
    ];

    public function company_position()
    {
        return $this->belongsTo(CompanyPosition::class, 'company_position_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function scopeForUser(Builder $query, User $user): Builder
    {
        // super_admin → ve TODO
        if ($user->hasRole('super_admin')) {
            return $query;
        }

        // company_owner / company_admin → empleados de su company
        if ($user->hasAnyRole(['company_owner', 'company_admin'])) {
            return $query->whereHas('branch', function ($q) use ($user) {
                $q->where('company_id', $user->companyId());
            });
        }

        // branch_manager → solo empleados de su sucursal
        if ($user->hasRole('branch_manager')) {
            return $query->where('branch_id', $user->branchId());
        }

        // fallback: no ve nada
        return $query->whereRaw('1 = 0');
    }
}
