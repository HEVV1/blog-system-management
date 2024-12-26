<?php

use App\Http\Controllers\Api\BlogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\EmailVerificationController;

//Authentication
Route::post('/register', [AuthController::class, 'register'])
    ->name('register');
Route::post('/login', [AuthController::class, 'login'])
    ->name('login');

// Blogs
Route::apiResource('blogs', BlogController::class)
    ->only(['index', 'show']);

//Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::apiResource('blogs', BlogController::class)
        ->only(['store', 'update', 'destroy']);
});

Route::get('/countries-language-json', [AuthController::class, 'countriesLanguageJson'])
    ->name('countries-language-json');

// Password reset
Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])
    ->name('password.email');
Route::post('/password/reset', [PasswordResetController::class, 'passwordReset'])
    ->name('password.reset');

// Email verification link
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware('signed')
    ->name('verification.verify');
Route::post('/email/resend', [EmailVerificationController::class, 'resend'])
    ->middleware('throttle:6,1')
    ->name('verification.resend');
