<?php

namespace App\Http\Controllers;

use App\Http\Requests\Appointments\{
    GetSingleRequest,
    DestroyRequest,
    StoreRequest,
    UpdateRequest
};
use App\Models\Appointment;

class AppointmentsController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user();
        if($user->role == 'ادمن') {
            return $this->generalResponse(Appointment::orderBy('status')->with(['driver', 'center'])->get());
        }
        return $this->generalResponse($user->driver->appointments()->orderBy('status')->with('center')->get());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $res = $request->check_centers($request->ad_id, $request->center_id);
        if(! $res) {
            return $this->generalResponse(null, 'The selected center must be exclusively among the centers available within the advertising campaign.', 400);
        }
        $request->store();
        return $this->generalResponse($res, 'A new appointment has been booked successfully, please wait for the admin to approve it.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(GetSingleRequest $request, Appointment $appointment)
    {
        return $this->generalResponse($appointment->load('center'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Appointment $appointment)
    {
        return $this->generalResponse($request->update($appointment), 'The appointment has been successfully approved.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyRequest $request, Appointment $appointment)
    {
        return $this->generalResponse($appointment->delete(), 'The appointment has been successfully deleted.');
    }
}
