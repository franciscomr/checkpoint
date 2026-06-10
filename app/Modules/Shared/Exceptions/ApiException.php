<?php

namespace App\Modules\Shared\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
abstract class ApiException extends Exception
{
    protected int $status = 500;

    protected string $errorCode = 'INTERNAL_SERVER_ERROR';

    protected array $errors = [];

    protected array $meta = [];

    public function __construct(
        ?string $message = null,
        array $errors = [],
        array $meta = []
    ) {
        parent::__construct(
            $message ?? $this->message
        );

        $this->errors = $errors;
        $this->meta = $meta;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function toArray(): array
    {
        return [
            'success' => false,
            'message' => $this->getMessage(),
            'code' => $this->errorCode,
            'errors' => $this->errors,
            'meta' => $this->meta,
        ];
    }
}
