<?php

use App\Modules\Company\Infrastructure\Controllers\BranchController;
use App\Modules\Company\Infrastructure\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function() {
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
});