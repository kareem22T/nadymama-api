<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\SpecializationController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::post('login', [AuthController::class, "login"]);

    Route::middleware(["auth:sanctum,admin"])->group(function () {

        /* doctors edpoints */
            Route::apiResource('doctors', DoctorController::class);
        ###########################################################

        /* doctors edpoints */
            Route::apiResource('specializations', SpecializationController::class);
        ###########################################################

        /* articles edpoints */
            Route::apiResource('articles', ArticleController::class);
        ###########################################################

    });

});
