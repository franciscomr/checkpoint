<?php

use Illuminate\Support\Facades\Route;

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
});

