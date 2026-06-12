<?php

namespace App\Modules\Auth\Exceptions;

use App\Modules\Shared\Exceptions\ApiException;
use Symfony\Component\HttpFoundation\Response;

class AuthTooManyAttemptsException extends ApiException
{
    protected $message = 'Too many login attempts';

    protected int $status = Response::HTTP_TOO_MANY_REQUESTS;

    protected string $errorCode = 'AUTH_TOO_MANY_ATTEMPTS';

    public function __construct(int $seconds)
    {
        parent::__construct(
            meta: [
                'retry_after' => $seconds,
            ]
        );
    }
}
