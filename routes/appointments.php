<?php

use App\Http\Controllers\AppointmentsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register auth routes.
|
*/

Route::apiResource('appointments', AppointmentsController::class)->except('destroy');
Route::patch('appointments/cancle/{appointment}', [AppointmentsController::class, 'cnacle']);

