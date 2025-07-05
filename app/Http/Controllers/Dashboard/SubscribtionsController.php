<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\Subscribtions\{
    JoiningApproveRequest,
    JoiningRejectRequest
};
use App\Http\Controllers\Controller;
use App\Http\Resources\GetSubscribtions;
use App\Models\DriverAd;
use Illuminate\Http\Request;

class SubscribtionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscribtions = DriverAd::whereAdId(request('ad_id'))->with('driver.user')->get();
        return $this->generalResponse(GetSubscribtions::collection($subscribtions));
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
    public function update(JoiningApproveRequest $request, string $id)
    {
        $request->approve($id);
        return $this->generalResponse(null, 'Done Successfully');
    }

        /**
     * Update the specified resource in storage.
     */
    public function reject(JoiningRejectRequest $request, string $id)
    {
        $request->reject($id);
        return $this->generalResponse(null, 'Done Successfully');
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
        ->whereStatus('in_progress')
        ->whereDriverId(request('driver_id'))
        ->with('driver.user')->first();
        return $this->generalResponse($driver->driver);
    }
}
