<?php

namespace App\Modules\Shared\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class TenantNotFoundException extends ApiException
{
    protected $message = 'Tenant not found';

    protected int $status = Response::HTTP_NOT_FOUND;

    protected string $errorCode = 'TENANT_NOT_FOUND';
    
}
