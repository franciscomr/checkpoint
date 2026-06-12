<?php

namespace App\Modules\Auth\Exceptions;

use App\Modules\Shared\Exceptions\ApiException;
use Symfony\Component\HttpFoundation\Response;

class AuthUserInactiveException extends ApiException
{
    protected $message = 'User is inactive';

    protected int $status = Response::HTTP_FORBIDDEN;

    protected string $errorCode = 'AUTH_USER_INACTIVE';
}
