<?php

use App\Http\Controllers\{
    CoordinatesController,
    ProfitsController,
    QrController,
    TrackingController,
    Stackholders\SubscribtionsController,
    Dashboard\HomeController,
    Frontend\StoriesController,

};

use App\Models\{
    Car,
    CarsYears,
    Center,
    City,
    Country,
    DeliveryPrograms,
    Lable,
    Region
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
// This route to get all avaliable years of cars to use it in register request.
Route::get('years', fn () => ['data' => CarsYears::whereCarId(request('car_id'))->pluck('year')->toArray()]);
// This route to get all avaliable delivery programs to use it in register request.
Route::get('programs', fn () => ['data' => DeliveryPrograms::all()]);
// This route to get all avaliable cities to use it in register request.
Route::get('countries', fn () => ['data' => Country::all()]);
Route::get('cities', fn () => [
    'data' => request('country_id') ?
        City::latest()->whereIsActive(1)->whereCountryId(request('country_id'))->get()
        :
        City::latest()->whereIsActive(1)->get()
]);
// This route to get all avaliable regions to use it in register request.
Route::get('regions', fn () => [
    'data' => request('city_id') ?
        Region::latest()->whereIsActive(1)->whereCityId(request('city_id'))->get()
        :
        Region::latest()->whereIsActive(1)->get()
]);
// This route to get all avaliable lables to use it in subscribe in ad request.
Route::get('lables', fn () => ['data' => Lable::all()]);
// This route to get all avaliable centers to use it in ad adding request.
Route::get('centers', fn () => ['data' => Center::whereRegionId(request('region_id'))->with('region')->get()]);

Route::middleware('auth:sanctum')->group(function() {

    // Get Single Ad Qr Code
    Route::get('qr/{id}', [QrController::class, 'show']);

    // Appointments Routes.
    include base_path('routes/appointments.php');

    // Profits Routes
    Route::apiResource('profits', ProfitsController::class);

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
        // Countries Routes.
        include base_path('routes/dashboard.countries.php');
        // Cities Routes.
        include base_path('routes/dashboard.cities.php');
        // Regions Routes.
        include base_path('routes/dashboard.regions.php');
        // Lables Routes.
        include base_path('routes/dashboard.lables.php');
        // Lables Routes.
        include base_path('routes/dashboard.stackholders.php');
        // Works Days Routes.
        include base_path('routes/dashboard.works_days.php');
        // Works Times Routes.
        include base_path('routes/dashboard.works_times.php');
        // Store Story Request
        Route::post('stories', [StoriesController::class, 'store']);
        // Home Page Routes
        Route::apiResource('home', HomeController::class);
        // Notifications Routes.
        include base_path('routes/dashboard.notifications.php');
    });

    // Stackholders Routes.
    Route::prefix('stackholders')->middleware('stackholder')->group(function() {
        // Ads Routes.
        include base_path('routes/ads.php');
        // Subscribtions Route
        Route::get('subscribtions', [SubscribtionsController::class, 'index']);
        Route::get('subscribtions/driver', [SubscribtionsController::class, 'driver']);
    });
    Route::get('stackholders/subscribtions/coordinates', [SubscribtionsController::class, 'coordinates'])->name('subscribtions.coordinates');

    // Drivers Routes.
    Route::prefix('drivers')->middleware(['driver', /*'verified',*/ 'active'])->group(function() {
        // Ads Routes.
        include base_path('routes/drivers.ads.php');
        // Tracking Routes
        Route::post('set-tracking-data', [TrackingController::class, 'set']);
    });

    // Notifications Routes.
    include base_path('routes/notifications.php');

    // GPS Routes
    Route::apiResource('coordinates', CoordinatesController::class);

});



