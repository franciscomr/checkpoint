<?php

namespace App\Modules\Authorization\Domain\Policies;

use App\Models\User;
use App\Modules\Company\Domain\Models\CompanyPosition;

class CompanyPositionPolicy
{
    public function view(User $user, CompanyPosition $position): bool
    {
        return $user->hasPermission('position.view', $position->company_id);
    }


    public function create(User $user, int $companyId): bool
    {
        return $user->hasPermission('position.create', $companyId);
    }


    public function update(User $user, CompanyPosition $position): bool
    {
        return $user->hasPermission('position.update', $position->company_id);
    }


    public function delete(User $user, CompanyPosition $position): bool
    {
        return $user->hasPermission('position.delete', $position->company_id);
    }
}
