<?php

use App\Http\Controllers\Dashboard\WorksDaysController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register auth routes.
|
*/

Route::apiResource('works-days', WorksDaysController::class);

