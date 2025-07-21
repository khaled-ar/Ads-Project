<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\WorksTimes\{
    StoreWorkTimeRequest,
    UpdateWorkTimeRequest
};
use App\Models\WorksTimes;
use Illuminate\Http\Request;

class WorksTimesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkTimeRequest $request)
    {
        return $this->generalResponse($request->store(), 'Work Time Added Successfully', 201);
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
    public function update(UpdateWorkTimeRequest $request, WorksTimes $works_time)
    {
        $request->update($works_time);
        return $this->generalResponse(null, 'Work Time Updated Successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorksTimes $works_time)
    {
        $works_time->delete();
        return $this->generalResponse(null, 'Work Time Deleted Successfully', 200);
    }
}
