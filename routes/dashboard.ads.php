<?php

use App\Http\Controllers\Dashboard\AdsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register auth routes.
|
*/

Route::apiResource('dash-ads', AdsController::class);
Route::patch('dash-ads/approve/{dash_ad}', [AdsController::class, 'approve']);
Route::patch('dash-ads/reject/{dash_ad}', [AdsController::class, 'reject']);
Route::get('dash-ads/ads/waiting-approval', [AdsController::class, 'waiting_approval']);

