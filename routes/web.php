<?php

use App\Http\Controllers\Frontend\LandingController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::controller(LandingController::class)->group(function() {
    Route::get('landing', 'show')->name('landing.show');
    Route::post('contact', 'submit_contact_form')->name('landing.submit');
});
