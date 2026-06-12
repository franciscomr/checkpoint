<?php

namespace App\Modules\Shared\Models;


use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Database\Factories\Shared\TenantFactory;

use App\Models\User;


#[Fillable(["name","slug"])]
class Tenant extends Model
{
    use HasUlids, HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    public function branches(): HasMany
    {
       return $this->hasMany(Branch::class); 
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

        protected static function newFactory()
    {
        return TenantFactory::new();
    }
}
