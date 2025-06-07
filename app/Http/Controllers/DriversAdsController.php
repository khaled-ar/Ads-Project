<?php

namespace App\Http\Controllers;

use App\Http\Requests\Drivers\ShowAdDetailsRequest;
use App\Http\Requests\Drivers\SubscribeInAdRequest;
use App\Models\Ad;
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
            'total_profits' => $ads->sum('profits'),
            'data' => $ads
        ]);
    }

    public function available_ads() {
        $ads = Ad::filter()->with('user')->whereStatus('قيد العمل')->get();
        return $this->generalResponse($ads);
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowAdDetailsRequest $request, Ad $ad)
    {
        return $this->generalResponse($request->appointements($ad));
    }

    public function subscribe(SubscribeInAdRequest $request, Ad $ad) {
        $res = $request->store($ad);
        return $this->generalResponse(null, $res[0], $res[1]);
    }
}
