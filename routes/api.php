<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\User\AppointmentController;
use App\Http\Controllers\User\ArticleController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\DoctorController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\SpecializationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

include(base_path('routes/admin.php'));
include(base_path('routes/doctor.php'));

Route::prefix('users')->group(function () {
    Route::post('login', [AuthController::class, "login"]);
    Route::post('register', [AuthController::class, "register"]);
    Route::get('/user/ask-email-verification-code', [AuthController::class, "askEmailCode"])->middleware('auth:sanctum');
    Route::post('/user/ask-for-forgot-password-email-code', [AuthController::class, "askEmailCodeForgot"]);
    Route::post('/user/forgot-password', [AuthController::class, "forgetPassword"]);
    Route::post('/user/forgot-password-check-code', [AuthController::class, "forgetPasswordCheckCode"]);

    Route::post('/user/verify-email', [AuthController::class, "verifyEmail"])->middleware('auth:sanctum');

    Route::middleware(["auth:sanctum"])->group(function () {

        /* users endpoints */
        Route::get('user', [AuthController::class, "user"]);
        ###########################################################

        /* appointments endpoints */
        Route::prefix('appointments')->group(function () {
            Route::post('book', [AppointmentController::class, "book"]);
            Route::get('/', [AppointmentController::class, "get"]);
        });
        ###########################################################

    });

    // get categories
    Route::get('categories', [SpecializationController::class, "index"]);
    Route::get('categories/all', [HomeController::class, "getAllCategories"]);

    Route::get('/specializations/{id}/doctors', [SpecializationController::class, 'getDoctorsBySpecialization']);
    Route::get('/doctor/{id}', [DoctorController::class, 'doctor']);

    // get doctors
    Route::get('doctors', [DoctorController::class, "index"]);
    Route::get('doctors/categories', [DoctorController::class, "getAllCategories"]);
    Route::get('doctors/positions', [DoctorController::class, "getAllPositions"]);
    Route::get('doctors/gouvernorats', [DoctorController::class, "getAllGouvernorats"]);

    // Add the new routes for paginating doctors
    Route::get('doctors/paginate', [HomeController::class, 'paginateDoctors']);
    Route::get('doctors/category/{categoryId}/paginate', [HomeController::class, 'paginateDoctorsByCategory']);

    // get articles
    Route::get('articles', [ArticleController::class, "index"]);
    Route::get('articles/{id}', [ArticleController::class, "article"]);

    // settings
    Route::get('settings', [HomeController::class, "get"]);
    Route::post('/messages', [MessageController::class, 'store']);

});
