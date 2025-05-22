<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\Cities\{
    StoreCityRequest,
    UpdateCityRequest,
};

use App\Http\Controllers\Controller;
use App\Models\City;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->generalResponse(City::with('regions')->latest()->get(), null, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCityRequest $request)
    {
        return $this->generalResponse(null, $request->store(), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCityRequest $request, City $city)
    {
        return $this->generalResponse(null, $request->update($city), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        $city->delete();
        return $this->generalResponse(null, 'City Deleted Suuccessfully.', 200);
    }
}
