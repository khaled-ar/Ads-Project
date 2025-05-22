<?php

use App\Models\{
    Car,
    Center,
    DeliveryPrograms
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Auth Routes.
include base_path('routes/auth.php');

// This route to get all avaliable cars to use it in register request.
Route::get('cars', fn () => ['data' => Car::all()]);
// This route to get all avaliable delivery programs to use it in register request.
Route::get('programs', fn () => ['data' => DeliveryPrograms::all()]);

Route::middleware('auth:sanctum')->group(function() {

    // This route to get all avaliable centers to use it in ad adding request.
    Route::get('centers', fn () => ['data' => Center::whereStatus('مفتوح')->get()]);
    // This route to get all avaliable cars to use it in register request.

    // Appointments Routes.
    include base_path('routes/appointments.php');

    // Dashboard Routes.
    Route::prefix('dashboard')->middleware('admin')->group(function() {
        // Drivers Routes.
        include base_path('routes/dashboard.drivers.php');
        // Ads Routes.
        include base_path('routes/dashboard.ads.php');
        // Subscriptions Routes.
        include base_path('routes/dashboard.subscribtions.php');
        // Centers Routes.
        include base_path('routes/dashboard.centers.php');
        // Cars Routes.
        include base_path('routes/dashboard.cars.php');
        // Delivery Programs Routes.
        include base_path('routes/dashboard.programs.php');
    });

    // Stackholders Routes.
    Route::prefix('stackholders')->middleware('stackholder')->group(function() {
        // Ads Routes.
        include base_path('routes/ads.php');
    });

    // Drivers Routes.
    Route::prefix('drivers')->middleware('driver')->group(function() {
        // Ads Routes.
        include base_path('routes/drivers.ads.php');
    });

    // Notifications Routes.
    include base_path('routes/notifications.php');

});



