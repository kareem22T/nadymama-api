<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\GouvernoratController;
use App\Http\Controllers\Admin\ImagesController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SpecializationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\User\AppointmentController;

Route::prefix('admin')->group(function () {
    Route::post('login', [AuthController::class, "login"]);

    Route::middleware(["auth:sanctum,admin"])->group(function () {

        /* doctors edpoints */
            Route::apiResource('doctors', DoctorController::class);
            Route::post('/update-doctor/{id}', [DoctorController::class, "update"]);
        ###########################################################

        /* doctors edpoints */
            Route::apiResource('specializations', SpecializationController::class);
        ###########################################################

        /* articles edpoints */
            Route::apiResource('articles', ArticleController::class);
        ###########################################################

        /* position edpoints */
            Route::apiResource('positions', PositionController::class);
        ###########################################################

        /* gouvernorat edpoints */
            Route::apiResource('gouvernorats', GouvernoratController::class);
        ###########################################################

        // images
        Route::post('/images/upload', [ImagesController::class, 'uploadeImg']);
        Route::post('/images/set-title', [ImagesController::class, 'putSEO']);
        Route::get('/images/get_images', [ImagesController::class, 'getImages']);
        Route::post('/images/search', [ImagesController::class, 'search']);

    });
    // settings
    Route::post('/settings/store', [SettingsController::class, 'store']);

    Route::get('/messages', [MessageController::class, 'index']);
    Route::get('/appointments', [AppointmentController::class, 'getAll']);

});
