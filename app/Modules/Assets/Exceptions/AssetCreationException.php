<?php

namespace App\Modules\Assets\Exceptions;

use App\Modules\Shared\Exceptions\ApiException;
use Symfony\Component\HttpFoundation\Response;

class AssetCreationException extends ApiException
{
    public static function categoryNotFound(): self
    {
        return (new self(
            message: 'Asset category not found'
        ))
            ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setErrorCode('ASSET_CATEGORY_NOT_FOUND');
    }

    public static function statusNotFound(): self
    {
        return (new self(
            message: 'Asset status not found'
        ))
            ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setErrorCode('ASSET_STATUS_NOT_FOUND');
    }

    public static function modelNotFound(): self
    {
        return (new self(
            message: 'Asset model not found'
        ))
            ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setErrorCode('ASSET_MODEL_NOT_FOUND');
    }

    public static function supplierNotFound(): self
    {
        return (new self(
            message: 'Supplier not found'
        ))
            ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setErrorCode('ASSET_SUPPLIER_NOT_FOUND');
    }
}
