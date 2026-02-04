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
use App\Models\DriverTrip;
use App\Notifications\DatabaseNotification;
use App\Notifications\FcmNotification;
use App\Services\CsvExportService;
use App\Services\QrService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as ResponseFacade;


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
        $dash_ad->total_steps = round(DriverTrip::whereAdId($dash_ad->id)->sum('steps'), 2);
        $dash_ad->drivers_count = DriverAd::whereAdId($dash_ad->id)->whereStatus('in_progress')->count() . ' / ' . $dash_ad->drivers_number;
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
                return $this->generalResponse(null, 'Campaign values ​must be completed before approval', 400);
            }
            $dash_ad->update(['status' => 'قيد العمل', 'created_at' => now()]);
            $subject = 'اشعار قبول حملة';
            $body = "تهانينا، لقد تم قبول حملة ({$dash_ad->name})";
            $dash_ad->user->notify(new DatabaseNotification($body, $subject, 'ad_approved'));
            $dash_ad->user->notify(new FcmNotification($subject, $body, ['ad_id' => $dash_ad->id]));
            $this->qr->generateQrCode($dash_ad);
            return $this->generalResponse(null, 'Ad Approved Successfully');
        });
    }

    public function reject(Ad $dash_ad) {
        return DB::transaction(function () use($dash_ad) {
            $subject = 'اشعار رفض حملة';
            $body = "مع الاسف، تم رفض حملة ({$dash_ad->name})";
            $dash_ad->user->notify(new DatabaseNotification($body, $subject, 'ad_rejected', request('notes')));
            $dash_ad->user->notify(new FcmNotification($subject, $body, ['ad_id' => $dash_ad->id]));
            $dash_ad->update(['notes' => request('notes'), 'status' => 'مرفوض']);
            return $this->generalResponse(null, 'Ad Rejected Successfully');;
        });
    }

    public function export_to_csv(Request $request, CsvExportService $exporter) {
        $ads = Ad::whereStatus('منتهية')->get();
        if ($ads->isEmpty()) {
            return $this->generalResponse(null, 'No Ads Yet', 400);
        }
        $headers = [
            'id',
            'company_name',
            'name',
            'images_count',
            'terms',
            'drivers_number',
            'budget',
            'step_price',
            'country',
            'city',
            'regions',
            'min_steps',
            'max_steps',
            'created_at',
        ];

        $rows = [];
        foreach ($ads as $ad) {
            $row = [];
            foreach ($headers as $header) {
                if($header == 'images_count') {
                    $row[] = count($ad->images_url ?? []);
                    continue;
                }
                if($header == 'step_price') {
                    $row[] = $ad->km_price;
                    continue;
                }
                if($header == 'min_steps') {
                    $row[] = $ad->km_min;
                    continue;
                }
                if($header == 'max_steps') {
                    $row[] = $ad->km_max;
                    continue;
                }
                $row[] = $ad->{$header} ?? '';
            }
            $rows[] = $row;
        }

        $filename = $exporter->export($headers, $rows, 'ended_campaigns.csv');
        return $this->generalResponse(['path' => asset("Exports/$filename")]);
    }
}
