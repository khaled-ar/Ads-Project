<?php

namespace App\Http\Controllers;

use App\Models\Profits;
use Illuminate\Http\Request;

class ProfitsController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin')->only(['index', 'destroy']);
        $this->middleware('driver')->only('store');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->generalResponse(Profits::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sham_cash_id = $request->validate([
            'sham_cash_id' => 'required', 'string', 'max:100', 'unique:profits,sham_cash_id'
        ])['sham_cash_id'];

        $profits = $request->user()->driver->ads()->whereStatus('done')->sum('profits');

        if($profits == 0) {
            return $this->generalResponse(null, 'You do not have any profits yet, please work harder!', 400);
        }

        Profits::create([
            'driver_id' => $request->user()->driver->id,
            'sham_cash_id' => $sham_cash_id,
            'profits' => $profits
        ]);

        return $this->generalResponse(null, 'Your Request Sent To Admin Successfully, PLease Wait for 24 Hours Maximum.');
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profits $profit)
    {
        $profit->driver->ads()->whereStatus('done')->delete();
        $profit->delete();
        return $this->generalResponse(null, 'Deleted Successfully.');
    }
}
