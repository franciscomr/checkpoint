<?php

namespace App\Modules\Company\Domain\Models;

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

    public function template()
    {
        return $this->belongsTo(DepartmentTemplate::class, 'department_template_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function positions()
    {
        return $this->hasMany(CompanyPosition::class, 'company_department_id');
    }
}
