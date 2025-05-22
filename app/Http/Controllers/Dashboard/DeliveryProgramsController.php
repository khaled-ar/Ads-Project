<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DeliveryPrograms;

use App\Http\Requests\Dashboard\Delivery_Programs\{
    StoreProgramRequest,
    UpdateProgramRequest
};

class DeliveryProgramsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->generalResponse(DeliveryPrograms::all(), null, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProgramRequest $request)
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
    public function update(UpdateProgramRequest $request, DeliveryPrograms $delivery_program)
    {
        return $this->generalResponse(null, $request->update($delivery_program), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeliveryPrograms $delivery_program)
    {
        $delivery_program->delete();
        return $this->generalResponse(null, 'Delivery Program Deleted Successfully.', 200);
    }
}
