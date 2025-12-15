<?php

namespace App\Modules\Company\Domain\Models;

use App\Modules\Shared\Infrastructure\Traits\AssignAuditFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepartmentTemplate extends Model
{
    use HasFactory, SoftDeletes, AssignAuditFields;

    protected $fillable = [
        'name',
        'description'
    ];

    public function company_departments(): HasMany
    {
        return $this->hasMany(CompanyDepartment::class, 'department_template_id');
    }
}
