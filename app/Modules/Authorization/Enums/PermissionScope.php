<?php

namespace App\Modules\Authorization\Enums;

enum PermissionScope: string
{
    case ALL = 'all';

    case TENANT = 'tenant';

    case BRANCH = 'branch';

    case DEPARTMENT = 'department';

    case OWN = 'own';
}