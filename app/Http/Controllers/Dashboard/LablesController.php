<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use App\Http\Requests\Dashboard\Lables\{
    StoreLableRequest,
    UpdateLableRequest
};
use App\Models\Lable;

class LablesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->generalResponse(Lable::all(), null, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLableRequest $request)
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
    public function update(UpdateLableRequest $request, Lable $lable)
    {
        return $this->generalResponse(null, $request->update($lable), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lable $lable)
    {
        $lable->delete();
        return $this->generalResponse(null, 'Lable Deleted Successfully.', 200);
    }
}
