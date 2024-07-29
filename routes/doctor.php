<?php

use App\Http\Controllers\Doctor\AppointmentController;
use App\Http\Controllers\Doctor\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('doctor')->group(function () {
    Route::post('login', [AuthController::class, "login"]);

    Route::middleware(["auth:sanctum,doctor"])->group(function () {
        Route::get('appointments', [AppointmentController::class, "get"]);
    });

});
