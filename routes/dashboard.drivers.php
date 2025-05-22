<?php

use App\Http\Controllers\Dashboard\DriversController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register auth routes.
|
*/

Route::apiResource('drivers', DriversController::class);
Route::patch('accounts/approve/{driver}', [DriversController::class, 'approve']);

