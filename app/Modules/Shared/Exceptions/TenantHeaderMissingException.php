<?php

namespace App\Modules\Shared\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class TenantHeaderMissingException extends ApiException
{
    protected $message = 'Tenant header is required';

    protected int $status = Response::HTTP_BAD_REQUEST;

    protected string $errorCode = 'TENANT_HEADER_MISSING';

    public function __construct()
    {
        parent::__construct(
            meta: [
                'required_header' => 'X-Tenant-ID',
            ]
        );
    }
}
