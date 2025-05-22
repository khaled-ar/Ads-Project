<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\Regions\{
    StoreRegionRequest,
    UpdateRegionRequest
};

use App\Http\Controllers\Controller;
use App\Models\Region;

class RegionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->generalResponse(Region::latest()->get(), null, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRegionRequest $request)
    {
        return $this->generalResponse(null, $request->store(), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Region $city)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRegionRequest $request, Region $region)
    {
        return $this->generalResponse(null, $request->update($region), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Region $region)
    {
        $region->delete();
        return $this->generalResponse(null, 'Region Deleted Suuccessfully.', 200);
    }
}
