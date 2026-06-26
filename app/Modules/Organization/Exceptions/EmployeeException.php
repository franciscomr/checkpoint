<?php

namespace App\Modules\Organization\Exceptions;

use App\Modules\Shared\Exceptions\ApiException;
use Symfony\Component\HttpFoundation\Response;

class EmployeeException extends ApiException
{
    public static function  EmployeeNotFoundException () :self
    { 
        return (new self(
            message : 'Employee not found'
        ))
        ->setStatus(Response::HTTP_NOT_FOUND)
        ->setErrorCode('EMPLOYEE_NOT_FOUND');
    }
}
