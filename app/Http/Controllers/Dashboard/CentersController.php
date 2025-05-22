<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\Centers\{
    StoreCenterRequest,
    UpdateCenterRequest,
};
use App\Http\Controllers\Controller;
use App\Models\Center;

class CentersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->generalResponse(Center::orderBy('status')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCenterRequest $request)
    {
        $request->store();
        return $this->generalResponse(null, 'Center Added Successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Center $center)
    {
        return $this->generalResponse($center);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCenterRequest $request, Center $center)
    {
        $request->update($center);
        return $this->generalResponse(null, 'Center Updated Successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Center $center)
    {
        $center->delete();
        return $this->generalResponse(null, 'Center Deleted Successfully', 200);
    }
}
