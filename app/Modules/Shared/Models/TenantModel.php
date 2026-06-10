<?php

namespace App\Modules\Shared\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Shared\Traits\BelongsToTenant;
abstract class TenantModel extends Model
{
    use BelongsToTenant;
}
