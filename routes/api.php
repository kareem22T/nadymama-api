<?php

use App\Http\Controllers\User\AppointmentController;
use App\Http\Controllers\User\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

include(base_path('routes/admin.php'));
include(base_path('routes/doctor.php'));

Route::prefix('users')->group(function () {
    Route::post('login', [AuthController::class, "login"]);
    Route::post('register', [AuthController::class, "register"]);

    Route::middleware(["auth:sanctum"])->group(function () {

        /* users edpoints */
            Route::get('user', [AuthController::class, "user"]);
        ###########################################################

        /* appointments edpoints */
            Route::prefix('appointments')->group(function () {
                Route::post('book', [AppointmentController::class, "book"]);
                Route::get('/', [AppointmentController::class, "get"]);
            });
        ###########################################################

    });

});
