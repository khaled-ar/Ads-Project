<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Ads\{
    StoreAdRequest,
    UpdateAdRequest
};
use App\Jobs\CalculateDriversProfits;
use App\Models\Ad;
use App\Models\DriverAd;
use App\Notifications\DatabaseNotification;
use App\Services\QrService;
use Illuminate\Support\Facades\DB;

class AdsController extends Controller
{
    public function __construct(private QrService $qr)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->generalResponse(Ad::status()->get(['id', 'status', 'name', 'created_at'])
                                    ->makeHidden(['from', 'images_url', 'is_full']));
    }

    public function waiting_approval()
    {
        return $this->generalResponse(Ad::with(['user', 'drivers.driver'])->whereStatus('بانتظار الموافقة')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdRequest $request)
    {
        $ad_id = $request->store();
        return $this->generalResponse(['ad_id' => $ad_id], 'Ad Added Successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ad $dash_ad)
    {
        return $this->generalResponse($dash_ad->load(['user', 'drivers.driver.user']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdRequest $request, Ad $dash_ad)
    {
        $data = $request->except('images');
        $dash_ad->update($data);
        return $this->generalResponse(null, 'Ad Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ad $dash_ad)
    {
        DriverAd::whereAdId($dash_ad->id)->update(['status' => 'done']);
        CalculateDriversProfits::dispatch();
        $dash_ad->delete();
        return $this->generalResponse(null, 'Ad Deleted Successfully');
    }

    public function approve(Ad $dash_ad) {
        return DB::transaction(function () use($dash_ad) {
            if($dash_ad->km_price == 0) {
                return $this->generalResponse(null, 'Campaign values ​​must be completed before approval', 400);
            }
            $dash_ad->update(['status' => 'قيد العمل', 'created_at' => now()]);
            $dash_ad->user->notify(new DatabaseNotification('تهانينا لقد تم قبول الحملة من قبل الادمن', 'قبول الحملة', 'ad_approved'));
            $this->qr->generateQrCode($dash_ad);
            return $this->generalResponse(null, 'Ad Approved Successfully');
        });
    }

    public function reject(Ad $dash_ad) {
        return DB::transaction(function () use($dash_ad) {
            $dash_ad->user->notify(new DatabaseNotification('للاسف لقد تم رفض الحملة من قبل الادمن', 'رفض الحملة', 'ad_rejected', request('notes')));
            $dash_ad->update(['notes' => request('notes'), 'status' => 'مرفوض']);
            return $this->generalResponse(null, 'Ad Rejected Successfully');;
        });
    }
}
