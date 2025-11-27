<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/preview', function () {
    return Inertia::render('Preview');
})->name('preview');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware('auth')->name('dashboard');

Route::post('/logout', [LoginController::class, 'destroy'])
    ->name('logout');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('login.throttle')->name('login.post');
});