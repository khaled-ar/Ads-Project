<?php

namespace App\Http\Controllers;

use App\Http\Requests\Stackholders\Ads\{
    DeleteAdRequest,
    ShowAdRequest,
    StoreAdRequest,
    UpdateAdRequest
};
use App\Models\Ad;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->generalResponse(request()->user()->ads);
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
    public function show(ShowAdRequest $request, Ad $ad)
    {
        return $this->generalResponse($ad->load('drivers.driver.user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdRequest $request, Ad $ad)
    {
        return $this->generalResponse(['ad_id' => $request->update($ad)], 'Ad Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteAdRequest $request, Ad $ad)
    {
        $request->delete($ad);
        return $this->generalResponse(null, 'Ad Deleted Successfully');
    }
}
