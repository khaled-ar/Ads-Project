<?php

namespace App\Http\Controllers\Stackholders;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\Drivers\DriverResource;
use App\Http\Resources\GetSubscribtions;
use App\Models\DriverAd;
use App\Services\GPS;
use Illuminate\Http\Request;

class SubscribtionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscribtions = DriverAd::whereAdId(request('ad_id'))->with('driver.user')->get()->map(function($subscribtion) {
            $formatted_driver = [
                'id' => $subscribtion->driver->id ?? 0,
                'name' => $subscribtion->driver->user->username ?? '',
                'image_url' => $subscribtion->driver->user->image_url ?? '',
                'status' => $subscribtion->status,
            ];
            unset($subscribtion->driver);
            return $formatted_driver;
        });
        return $this->generalResponse($subscribtions);
    }

    public function coordinates() {
        $subscribtions = DriverAd::whereAdId(request('ad_id'))->with('driver.user')->get()->map(function($subscribtion) {
            $coordinates = (new GPS())->get($subscribtion->driver_id);
            $formatted_driver = [
                'driver_id' => $subscribtion->driver_id,
                'driver_name' => $subscribtion->driver->user->username ?? '',
                'lon' => $coordinates['lon'] ?? null,
                'lat' => $coordinates['lat'] ?? null,
            ];
            unset($subscribtion->driver);
            return $formatted_driver;
        });
        return $this->generalResponse($subscribtions);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function driver(Request $request) {
        $driver = DriverAd::whereAdId(request('ad_id'))
        ->whereDriverId(request('driver_id'))
        ->with('driver.user')->first();
        return $this->generalResponse(new DriverResource($driver->driver, $driver->lables));
    }
}
