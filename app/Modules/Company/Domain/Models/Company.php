<?php

namespace App\Modules\Company\Domain\Models;

use App\Modules\Shared\Infrastructure\Traits\AssignAuditFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Company\Domain\Models\Branch;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'tax_id', 'logo_path', 'address', 'city', 'state', 'postal_code'
        ,'created_by','updated_by'
    ];

    public function branches():HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function departments():HasMany
    {
        return $this->hasMany(CompanyDepartment::class);
    }
}
