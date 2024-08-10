<?php

use App\Http\Controllers\Doctor\AppointmentController;
use App\Http\Controllers\Doctor\AuthController;
use App\Http\Controllers\Doctor\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::prefix('doctor')->group(function () {
    Route::post('login', [AuthController::class, "login"]);

    Route::middleware(["auth:sanctum,doctor"])->group(function () {
        Route::get('appointments', [AppointmentController::class, "get"]);
        Route::post('/cancel-day-or-date', [ScheduleController::class, "create"]);
    });

});
