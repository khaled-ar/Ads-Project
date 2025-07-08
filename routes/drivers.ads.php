<?php

use App\Http\Controllers\DriversAdsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register auth routes.
|
*/

Route::controller(DriversAdsController::class)->group(function() {
    Route::get('ads', 'index');
    Route::get('available-ads', 'available_ads');
    Route::post('ads/{ad}', 'subscribe');
    Route::get('ads/{ad}', 'show');
    Route::post('ads/make-inprogress/{ad_id}', 'make_inprogress');
});
