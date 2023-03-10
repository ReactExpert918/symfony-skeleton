<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');
    Route::post('login', [ApiController::class, 'getToken']);
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('is.token')
    ->name('logout');
