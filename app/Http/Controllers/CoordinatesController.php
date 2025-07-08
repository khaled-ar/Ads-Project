<?php

namespace App\Http\Controllers;

use App\Http\Requests\Coordinates\StoreCoordinatesRequest;
use App\Services\GPS;
use Illuminate\Http\Request;

class CoordinatesController extends Controller
{

    public function __construct(private GPS $gps) {}
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
    public function store(StoreCoordinatesRequest $request)
    {
        $user_id = $request->user()->id;
        return $this->generalResponse($this->gps->set($user_id, $request->lat, $request->lon));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->generalResponse($this->gps->get($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
