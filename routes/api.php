<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('/login', 'login');
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', 'logout');
        });
    });

    Route::controller(EventController::class)->prefix('events')->group(function () {
        Route::get('/all', 'getAllEvents');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::controller(EventController::class)->prefix('events')->group(function () {
            Route::post('/{event:slug}/register', 'eventRegister');
        });

        Route::resource('events', EventController::class);
    });
});
