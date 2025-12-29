<?php

namespace App\Modules\Company\Domain\Models;

use App\Models\User;
use App\Modules\Shared\Infrastructure\Traits\AssignAuditFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyDepartment extends Model
{
    use HasFactory, SoftDeletes, AssignAuditFields;

    protected $fillable = [
        'company_id',
        'department_template_id',
        'name',
        'description',
    ];

    public function department_template()
    {
        return $this->belongsTo(DepartmentTemplate::class, 'department_template_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function company_positions()
    {
        return $this->hasMany(CompanyPosition::class);
    }

    public function scopeForUser($query, User $user)
    {
        if ($user->hasRole('super_admin')) {
            return $query;
        }

        return $query->where('company_id', $user->companyId());
    }
}
