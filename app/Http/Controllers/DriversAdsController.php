<?php

namespace App\Http\Controllers;

use App\Http\Requests\Drivers\ShowAdDetailsRequest;
use App\Http\Requests\Drivers\SubscribeInAdRequest;
use App\Models\Ad;
use App\Models\DriverAd;
use Illuminate\Http\Request;

class DriversAdsController extends Controller
{
    public function index() {
        $ads = request()->user()->driver->ads()->orderByDesc('status')->get();
        $count = count($ads);
        if($count == 0) {
            return $this->generalResponse(null, 'No Ads Yet.');
        }

        return response()->json([
            'message' => null,
            'has_current' => $ads[0]->status == 'in_progress',
            'total_ads' => $count,
            'total_profits' => round($ads->sum('profits'), 2),
            'data' => $ads
        ]);
    }

    public function available_ads() {
        $ads = Ad::filter()->with('user')->whereStatus('قيد العمل')->get();
        return $this->generalResponse($ads);
    }

    public function show(ShowAdDetailsRequest $request, Ad $ad)
    {
        return $this->generalResponse($request->appointements($ad));
    }

    public function subscribe(SubscribeInAdRequest $request, Ad $ad) {
        $res = $request->store($ad);
        return $this->generalResponse(null, $res[0], $res[1]);
    }

    public function make_inprogress(Request $request) {
        $subscription = DriverAd::whereAdId($request->ad_id)
            ->whereDriverId($request->user()->driver->id)
            ->whereStatus('appointement_booking')
            ->update(['status' => 'in_progress']);

        if(! $subscription) {
            return $this->generalResponse(null, 'There is an error.', 400);
        }

        return $this->generalResponse(null, 'Done Successfully.', 200);
    }
}
