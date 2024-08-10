<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\ImagesController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\SpecializationController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::post('login', [AuthController::class, "login"]);

    Route::middleware(["auth:sanctum,admin"])->group(function () {

        /* doctors edpoints */
            Route::apiResource('doctors', DoctorController::class);
            Route::update('doctors/{id}/update', [DoctorController::class, "update"]);
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

        // images
        Route::post('/images/upload', [ImagesController::class, 'uploadeImg']);
        Route::post('/images/set-title', [ImagesController::class, 'putSEO']);
        Route::get('/images/get_images', [ImagesController::class, 'getImages']);
        Route::post('/images/search', [ImagesController::class, 'search']);
    });

});
