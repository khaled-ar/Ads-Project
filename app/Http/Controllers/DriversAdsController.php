<?php

namespace App\Http\Controllers;

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
            'total_ads' => $ads,
            'total_profits' => $ads->sum('profits'),
            'data' => $ads
        ]);
    }

    public function available_ads() {
        $ads = Ad::with('user')->whereStatus('قيد العمل')->get();
        return $this->generalResponse($ads);
    }

    public function subscribe() {

    }
}
