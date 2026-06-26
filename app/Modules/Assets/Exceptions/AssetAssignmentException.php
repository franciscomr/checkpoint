<?php

namespace App\Modules\Assets\Exceptions;

use App\Modules\Shared\Exceptions\ApiException;
use Symfony\Component\HttpFoundation\Response;

class AssetAssignmentException extends ApiException
{
    public static function  AssetAlreadyAssignedException () :self
    { 
        return (new self(
            message : 'Asset is already assigned'
        ))
        ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->setErrorCode('CROSS_TENANT_ASSIGNMENT');
    }

    public static function  CrossTenantAssignmentException () :self
    { 
        return (new self(
            message : 'Asset and employee belong to different tenants'
        ))
        ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->setErrorCode('ASSET_ALREADY_ASSIGNED');
    }

    public static function  AssetNotFoundException () :self
    { 
        return (new self(
            message : 'Asset not found'
        ))
        ->setStatus(Response::HTTP_NOT_FOUND)
        ->setErrorCode('ASSET_NOT_FOUND');
    }

    public static function AssignedStatusNotFound () :self
    {
        return (new self(
            message : 'Assigned Status not found'
        ))
        ->setStatus(Response::HTTP_NOT_FOUND)
        ->setErrorCode('ASSIGNED_STATUS_NOT_FOUND'); 
    }

    public static function noActiveAssignment() :self
    {
        return (new self(
            message : 'No Active Assigment'
        ))
        ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->setErrorCode('NO_ACTIVE_ASSIGNMENT'); 
    }

    public static function availableStatusNotFound() :self
    {
        return (new self(
            message : 'Available Status Not Found'
        )) 
        ->setStatus(Response::HTTP_NOT_FOUND)
        ->setErrorCode('AVAILABLE_STATUS_NOT_FOUND'); 
    }

    public static function cannotTransferToSameEmployee() :self
    {
        return (new self(
            message : 'Cannot transfer to same Employee'
        )) 
        ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->setErrorCode('CANNOT_TRANSFER_TO_SAME_EMPLOYEE'); 
    }

    public static function activeAssignmentNotFound() :self
    {
        return (new self(
            message : 'Active Assignment Not Found'
        )) 
        ->setStatus(Response::HTTP_NOT_FOUND)
        ->setErrorCode('ACTIVE_ASSIGNMENT_NOT_FOUND'); 
    }

    
    
}
