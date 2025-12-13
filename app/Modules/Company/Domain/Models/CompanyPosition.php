<?php

namespace App\Modules\Company\Domain\Models;

use App\Modules\Shared\Infrastructure\Traits\AssignAuditFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyPosition extends Model
{
    use HasFactory, SoftDeletes, AssignAuditFields;

    protected $fillable = [
        'company_department_id',
        'position_template_id',
        'name',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function template()
    {
        return $this->belongsTo(PositionTemplate::class, 'position_template_id');
    }

    public function department()
    {
        return $this->belongsTo(CompanyDepartment::class, 'company_department_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'company_position_id');
    }
}
