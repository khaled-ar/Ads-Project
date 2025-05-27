<?php

use App\Http\Controllers\Dashboard\WorksTimesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register auth routes.
|
*/

Route::apiResource('works-times', WorksTimesController::class);

