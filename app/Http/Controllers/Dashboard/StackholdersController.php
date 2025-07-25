<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Stackholders\{
    StoreStackholderRequest,
};
use App\Models\User;
use Illuminate\Http\Request;

class StackholdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->generalResponse(User::whereRole('معلن')->get(), null, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStackholderRequest $request)
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::whereId($id)->delete();
        return $this->generalResponse(null, 'Stackholder Deleted Successfully.', 200);
    }
}
