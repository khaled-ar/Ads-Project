<?php

use App\Http\Controllers\Dashboard\DeliveryProgramsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register auth routes.
|
*/

Route::apiResource('delivery-programs', DeliveryProgramsController::class);

