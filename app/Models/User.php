<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Modules\Authorization\Domain\Models\Role;
use App\Modules\Authorization\Domain\Traits\HasPermissions;
use App\Modules\Authorization\Domain\Traits\HasRoles;
use App\Modules\Company\Domain\Models\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'employee_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function companyId(): ?int
    {
        if (!$this->employee_id) {
            return null;
        }

        $this->loadMissing('employee.branch');

        return $this->employee?->branch?->company_id;
    }

    public function branchId(): ?int
    {
        if (!$this->employee_id) {
            return null;
        }

        $this->loadMissing('employee.branch');

        return $this->employee?->branch?->id;
    }

    // =====================================================
    // Relationships
    // =====================================================


    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles')
            ->withTimestamps();
    }


    // =====================================================
    // Role helpers
    // =====================================================


    public function hasRole(string $role): bool
    {
        return $this->roles->contains('slug', $role);
    }


    public function hasAnyRole(array $roles): bool
    {
        return $this->roles->whereIn('slug', $roles)->isNotEmpty();
    }


    // =====================================================
    // Permission helpers
    // =====================================================


    public function permissions()
    {
        return $this->roles
            ->loadMissing('permissions')
            ->pluck('permissions')
            ->flatten()
            ->unique('id');
    }


    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->contains('slug', $permission);
    }


    public function hasAnyPermission(array $permissions): bool
    {
        return $this->permissions()->whereIn('slug', $permissions)->isNotEmpty();
    }
}
