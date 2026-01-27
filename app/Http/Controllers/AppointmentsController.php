<?php

namespace App\Http\Controllers;

use App\Http\Requests\Appointements\{
    GetSingleRequest,
    DestroyRequest,
    StoreRequest,
    UpdateRequest
};
use App\Models\Appointement;

class AppointmentsController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = request()->user()->driver->appointments()->with('ad')->latest()->get()->map(function($appointment) {
            return [
                'id' => $appointment->id,
                'ad_id' => $appointment->ad_id,
                'center_id' => $appointment->center_id,
                'day' => ($appointment->center->works_days()->where('id', $appointment->works_days_id)->first())->day,
                'time' => $appointment->time,
                'center_name' => $appointment->center->name,
                'center_location' => $appointment->center->location,
                'ad_name' => $appointment->ad->name,
                'status' => $appointment->status
            ];
        });
        return $this->generalResponse($appointments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $res = $request->store();
        return $this->generalResponse(null, $res[0], $res[1]);
    }

    /**
     * Display the specified resource.
     */
    public function show(GetSingleRequest $request, Appointement $appointment)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Appointement $appointment)
    {
        return $this->generalResponse($request->update($appointment), 'The appointment has been successfully approved.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function cnacle(DestroyRequest $request, Appointement $appointment)
    {
        return $this->generalResponse($request->cancle($appointment), 'The appointment has been successfully canceled.');
    }
}
