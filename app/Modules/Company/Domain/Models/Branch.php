<?php

namespace App\Modules\Company\Domain\Models;

use App\Models\User;
use App\Modules\Shared\Infrastructure\Traits\AssignAuditFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes, AssignAuditFields;

    protected $fillable = [
        'company_id',
        'name',
        'address',
        'city',
        'state',
        'postal_code'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function scopeForUser($query, User $user)
    {
        if ($user->hasRole('super_admin')) {
            return $query;
        }

        return $query->where('company_id', $user->companyId());
    }
}
