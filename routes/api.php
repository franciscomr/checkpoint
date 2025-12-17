<?php

use App\Modules\Auth\Infrastructure\Controllers\AuthController;
use App\Modules\Auth\Infrastructure\Controllers\SessionController;
use App\Modules\Company\Infrastructure\Controllers\BranchController;
use App\Modules\Company\Infrastructure\Controllers\CompanyController;
use App\Modules\Company\Infrastructure\Controllers\CompanyDepartmentController;
use App\Modules\Company\Infrastructure\Controllers\CompanyPositionController;
use App\Modules\Company\Infrastructure\Controllers\DepartmentTemplateController;
use App\Modules\Company\Infrastructure\Controllers\PositionTemplateController;
use App\Modules\Company\Infrastructure\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->middleware(['web'])->group(function() {

    Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
    Route::get('/sessions',[SessionController::class,'index'])->middleware('auth');
    Route::delete('/sessions/{session}',[SessionController::class,'destroy'])->middleware('auth');

    Route::get('/companies',[CompanyController::class, 'index']);
    Route::post('/companies', [CompanyController::class, 'store']);
    Route::get('/companies/{id}',[CompanyController::class, 'show']);
    Route::put('/companies/{id}', [CompanyController::class, 'update']);
    Route::delete('/companies/{id}', [CompanyController::class, 'destroy']);

    Route::get('/companies/{id}/branches', [CompanyController::class, 'branches']);

    Route::get('/branches',[BranchController::class, 'index']);
    Route::post('/branches', [BranchController::class, 'store']);
    Route::get('/branches/{id}',[BranchController::class, 'show']);
    Route::put('/branches/{id}', [BranchController::class, 'update']);
    Route::delete('/branches/{id}', [BranchController::class, 'destroy']);

    Route::get('/department_templates',[DepartmentTemplateController::class, 'index']);
    Route::post('/department_templates', [DepartmentTemplateController::class, 'store']);
    Route::get('/department_templates/{id}',[DepartmentTemplateController::class, 'show']);
    Route::put('/department_templates/{id}', [DepartmentTemplateController::class, 'update']);
    Route::delete('/department_templates/{id}', [DepartmentTemplateController::class, 'destroy']);

    Route::get('/position_templates',[PositionTemplateController::class, 'index']);
    Route::post('/position_templates', [PositionTemplateController::class, 'store']);
    Route::get('/position_templates/{id}',[PositionTemplateController::class, 'show']);
    Route::put('/position_templates/{id}', [PositionTemplateController::class, 'update']);
    Route::delete('/position_templates/{id}', [PositionTemplateController::class, 'destroy']);

    Route::get('/company_departments',[CompanyDepartmentController::class, 'index']);
    Route::post('/company_departments', [CompanyDepartmentController::class, 'store']);
    Route::get('/company_departments/{id}',[CompanyDepartmentController::class, 'show']);
    Route::put('/company_departments/{id}', [CompanyDepartmentController::class, 'update']);
    Route::delete('/company_departments/{id}', [CompanyDepartmentController::class, 'destroy']);

    Route::get('/company_positions',[CompanyPositionController::class, 'index']);
    Route::post('/company_positions', [CompanyPositionController::class, 'store']);
    Route::get('/company_positions/{id}',[CompanyPositionController::class, 'show']);
    Route::put('/company_positions/{id}', [CompanyPositionController::class, 'update']);
    Route::delete('/company_positions/{id}', [CompanyPositionController::class, 'destroy']);

    Route::get('/employees',[EmployeeController::class, 'index']);
    Route::post('/employees', [EmployeeController::class, 'store']);
    Route::get('/employees/{id}',[EmployeeController::class, 'show']);
    Route::put('/employees/{id}', [EmployeeController::class, 'update']);
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);
});

