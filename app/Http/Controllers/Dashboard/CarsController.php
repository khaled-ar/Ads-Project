<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Car;

use App\Http\Requests\Dashboard\Cars\{
    StoreCarRequest,
    UpdateCarRequest
};

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->generalResponse(Car::all(), null, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarRequest $request)
    {
        return $this->generalResponse(null, $request->store(), 201);
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
    public function update(UpdateCarRequest $request, Car $car)
    {
        return $this->generalResponse(null, $request->update($car), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $car->delete();
        return $this->generalResponse(null, 'Car Deleted Successfully.', 200);
    }
}
