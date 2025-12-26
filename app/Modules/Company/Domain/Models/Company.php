<?php

namespace App\Modules\Company\Domain\Models;

use App\Models\User;
use App\Modules\Shared\Infrastructure\Traits\AssignAuditFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Company\Domain\Models\Branch;

class Company extends Model
{
    use HasFactory, SoftDeletes, AssignAuditFields;

    protected $fillable = [
        'name',
        'tax_id',
        'logo_path',
        'address',
        'city',
        'state',
        'postal_code'
    ];

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function departments(): HasMany
    {
        return $this->hasMany(CompanyDepartment::class);
    }

    public function scopeForUser($query, User $user)
    {
        if ($user->hasRole('super_admin')) {
            return $query;
        }

        return $query->where('id', $user->companyId());
    }
}
