<?php

namespace App\Modules\Company\Domain\Models;

use App\Modules\Shared\Infrastructure\Traits\AssignAuditFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PositionTemplate extends Model
{
    use HasFactory, SoftDeletes, AssignAuditFields;

    protected $fillable = [
        'department_template_id',
        'name',
        'description',
    ];

    public function departmentTemplate()
    {
        return $this->belongsTo(DepartmentTemplate::class, 'department_template_id');
    }

    public function companyPositions()
    {
        return $this->hasMany(CompanyPosition::class, 'position_template_id');
    }
}
