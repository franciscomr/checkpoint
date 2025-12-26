<?php

namespace App\Modules\Company\Domain\Models;

use App\Modules\Authorization\Domain\Models\Role;
use App\Modules\Shared\Infrastructure\Traits\AssignAuditFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
