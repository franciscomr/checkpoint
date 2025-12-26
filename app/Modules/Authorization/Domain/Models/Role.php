<?php

namespace App\Modules\Authorization\Domain\Models;

use App\Models\User;
use App\Modules\Shared\Infrastructure\Traits\AssignAuditFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes, AssignAuditFields;
    
    protected $fillable = [
        'name',
        'slug',
        'scope', // global | company
    ];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_roles')
            ->withPivot('company_id')
            ->withTimestamps();
    }

    public function isGlobal(): bool
    {
        return $this->scope === 'global';
    }

    public function isCompany(): bool
    {
        return $this->scope === 'company';
    }
}
