<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Modules\Authorization\Domain\Policies\BranchPolicy;
use App\Modules\Authorization\Domain\Policies\CompanyDepartmentPolicy;
use App\Modules\Authorization\Domain\Policies\CompanyPolicy;
use App\Modules\Authorization\Domain\Policies\CompanyPositionPolicy;
use App\Modules\Authorization\Domain\Policies\DepartmentTemplatePolicy;
use App\Modules\Authorization\Domain\Policies\EmployeePolicy;
use App\Modules\Authorization\Domain\Policies\PositionTemplatePolicy;
use App\Modules\Company\Domain\Models\Branch;
use App\Modules\Company\Domain\Models\Company;
use App\Modules\Company\Domain\Models\CompanyDepartment;
use App\Modules\Company\Domain\Models\CompanyPosition;
use App\Modules\Company\Domain\Models\DepartmentTemplate;
use App\Modules\Company\Domain\Models\Employee;
use App\Modules\Company\Domain\Models\PositionTemplate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Company::class => CompanyPolicy::class,
        Branch::class => BranchPolicy::class,
        DepartmentTemplate::class => DepartmentTemplatePolicy::class,
        PositionTemplate::class => PositionTemplatePolicy::class,
        CompanyDepartment::class => CompanyDepartmentPolicy::class,
        CompanyPosition::class => CompanyPositionPolicy::class,
        Employee::class => EmployeePolicy::class,
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
