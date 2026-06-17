<?php

namespace App\Modules\Shared\Exceptions;

use Exception;

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

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getMeta(): array
    {
        return $this->meta;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function setErrorCode(string $errorCode): static
    {
        $this->errorCode = $errorCode;

        return $this;
    }

    public function setErrors(array $errors): static
    {
        $this->errors = $errors;

        return $this;
    }

    public function setMeta(array $meta): static
    {
        $this->meta = $meta;

        return $this;
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