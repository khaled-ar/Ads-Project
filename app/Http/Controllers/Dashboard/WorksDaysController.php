<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\WorksDays\StoreWorkDayRequest;
use App\Http\Requests\Dashboard\WorksDays\UpdateWorkDayRequest;
use App\Models\WorksDays;
use Illuminate\Http\Request;

class WorksDaysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->generalResponse(WorksDays::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkDayRequest $request)
    {
        $request->store();
        return $this->generalResponse(null, 'Work Day Added Successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(WorksDays $work_day)
    {
        return $this->generalResponse($work_day);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkDayRequest $request, WorksDays $work_day)
    {
        $request->update($work_day);
        return $this->generalResponse(null, 'Work Day Updated Successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorksDays $work_day)
    {
        $work_day->delete();
        return $this->generalResponse(null, 'Work Day Deleted Successfully', 200);
    }
}
