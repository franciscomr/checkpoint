<?php

use App\Modules\Assets\Controllers\AssetController;
use Illuminate\Support\Facades\Route;
use App\Modules\Auth\Controllers\AuthController;
use App\Modules\Auth\Controllers\MeController;
use App\Modules\Auth\Controllers\LogoutController;

Route::prefix('v1')->group(function () {
    Route::get('me', function () {
        return response()->json([
            'user_id'=> '1',
            'tenant_id'=> '2',
        ]);
    });

    Route::get('/tenant-test', function () {
        return response()->json([
        'tenant_id' => tenant_id(),
        ]);
    });

    Route::post('/login', [AuthController::class, 'login'])->name('post.login');

    Route::middleware(['auth:sanctum',])->get('/me', MeController::class);


    Route::post('/logout', LogoutController::class)->middleware('auth:sanctum');

    Route::post('/assets',[AssetController::class, 'store']);

});

