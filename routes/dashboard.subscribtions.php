<?php

use App\Http\Controllers\Dashboard\SubscribtionsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register auth routes.
|
*/

Route::apiResource('subscriptions', SubscribtionsController::class);

