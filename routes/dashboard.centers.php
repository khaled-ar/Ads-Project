<?php

use App\Http\Controllers\Dashboard\CentersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register auth routes.
|
*/

Route::apiResource('centers', CentersController::class);

