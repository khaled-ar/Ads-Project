<?php

use App\Http\Controllers\Dashboard\CitiesController;
use App\Http\Controllers\Dashboard\CountriesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register auth routes.
|
*/

Route::apiResource('countries', CountriesController::class);

