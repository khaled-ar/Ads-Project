<?php

use App\Http\Controllers\Auth\{
    EmailController,
    AuthController
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register auth routes.
|
*/

Route::prefix('auth')
    ->controller(AuthController::class)
    ->group(function() {
        // Register Route.
        Route::post('register', 'register');
        // Login Route.
        Route::post('login', 'login');
        // Forgot Password Route.
        Route::patch('reset-password', 'reset_password');
        // Update Driver Profile Route.
        Route::patch('update-driver-profile', 'update_driver_profile')->middleware('auth:sanctum');
        Route::delete('logout', 'logout')->middleware('auth:sanctum');
    });

Route::controller(EmailController::class)
    ->group(function() {
        Route::patch('verify-email', 'verify');
        Route::post('forgot-password', 'forgot_password');
        Route::get('resend-code', 'resend_code');
    });


