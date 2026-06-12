<?php

namespace App\Modules\Auth\Exceptions;

use App\Modules\Shared\Exceptions\ApiException;
use Symfony\Component\HttpFoundation\Response;

class AuthInvalidCredentialsException extends ApiException
{
    protected $message = 'Invalid credentials';

    protected int $status = Response::HTTP_UNAUTHORIZED;

    protected string $errorCode = 'AUTH_INVALID_CREDENTIALS';
}
