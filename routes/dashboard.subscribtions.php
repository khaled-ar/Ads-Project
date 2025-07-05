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
Route::patch('subscriptions/reject/{id}', [SubscribtionsController::class, 'reject']);
Route::get('subscriptions/{ad_id}/driver', [SubscribtionsController::class, 'driver']);


