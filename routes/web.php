<?php

use App\Http\Controllers\Frontend\LandingController;
use App\Http\Controllers\Frontend\StoriesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::controller(LandingController::class)->group(function() {
    Route::get('landing', 'show')->name('landing.show');
    Route::post('contact', 'submit_contact_form')->name('landing.submit');
});


Route::controller(StoriesController::class)->group(function() {
    Route::get('stories/all', 'index')->name('stories.index');
    Route::get('stories/{story}/prize', 'prize_form')->name('stories.prize-form');
    Route::post('stories/form-submit/{story}', 'form_submit')->name('stories.prize-form-submit');
});

