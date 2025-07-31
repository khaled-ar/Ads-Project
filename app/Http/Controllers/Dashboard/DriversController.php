<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Drivers\UpdateDriverRequest;
use Illuminate\Http\Request;
use App\Traits\Files;
use App\Http\Resources\Dashboard\Drivers\{
    DriversResource,
    DriverResource
};
use App\Models\{
    User,
    Driver
};
use App\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\DB;

class DriversController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = User::with('driver')->whereRole('سائق')->orderBy('account_status')->get();
        return $this->generalResponse($drivers);
    }

    public function inactive_users() {
        $drivers = User::with('driver')->whereRole('سائق')->whereAccountStatus('inactive')->get();
        return $this->generalResponse($drivers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        $driver = $driver->load('user');
        return $this->generalResponse(new DriverResource($driver, ''));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDriverRequest $request, Driver $driver)
    {
        return $this->generalResponse($request->update($driver), 'Driver Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        $driver->user()->delete();
        Files::deleteFile(public_path('Driver_Files/') . $driver->details_file);
        $driver->delete();
        return $this->generalResponse(null, 'Driver Deleted Successfully');
    }

    public function approve(Driver $driver) {
        return DB::transaction(function () use($driver) {
            $driver->user()->update([
                'account_status' => 'active'
            ]);
            $driver->user->notify(new DatabaseNotification('تهانينا لقد تم قبول حسابك من قبل الادمن', 'طلب انضمام', 'account_status'));
            return $this->generalResponse(null, 'Account Approved Successfully');;
        });
    }

        public function reject(Driver $driver) {
        return DB::transaction(function () use($driver) {
            $driver->user()->update([
                'account_status' => 'rejected',
                'notes' => request('notes'),
                'rejected_at' => now()
            ]);
            $driver->user->notify(new DatabaseNotification('للاسف لقد تم رفض حسابك من قبل الادمن، الرجاء مراجعة سبب الرفض واعادة طلب الانضمام خلال يوم او يومين وشكرا', 'طلب انضمام', 'account_status', request('notes')));
            return $this->generalResponse(null, 'Account Rejected Successfully');;
        });
    }
}
