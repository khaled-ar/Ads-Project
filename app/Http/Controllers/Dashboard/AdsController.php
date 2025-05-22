<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Ads\{
    StoreAdRequest,
    UpdateAdRequest
};
use App\Models\Ad;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->generalResponse(Ad::with(['user', 'drivers.driver'])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdRequest $request)
    {
        $ad_id = $request->store();
        return $this->generalResponse(['ad_id' => $ad_id], 'Ad Added Successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ad $dash_ad)
    {
        return $this->generalResponse($dash_ad->load(['user', 'drivers.driver.user']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdRequest $request, Ad $dash_ad)
    {
        $data = $request->except('images');
        $dash_ad->update($data);
        return $this->generalResponse(null, 'Ad Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ad $dash_ad)
    {
        $dash_ad->delete();
        return $this->generalResponse(null, 'Ad Deleted Successfully');
    }
}
