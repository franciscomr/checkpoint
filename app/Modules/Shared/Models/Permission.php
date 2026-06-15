<?php

namespace App\Modules\Shared\Models;

use App\Modules\Shared\Database\Factories\PermissionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


#[Fillable(['name', 'module', 'slug'])]
class Permission extends Model
{
    use HasFactory;
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->withPivot('scope');
    }

    protected static function newFactory()
    {
        return PermissionFactory::new();
    }
}
