<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetTrackingData;
use App\Services\GPS;

class TrackingController extends Controller
{
    public function __construct(private GPS $tracking_data) {}


    public function set(SetTrackingData $request) {
        $res = $this->tracking_data->set_data($request->driver_id,
                                                $request->ad_id,
                                                $request->distance,
                                                $request->traffic,
                                                $request->time,
                                                $request->sector
                                            );
        return $this->generalResponse($res[2], $res[0], $res[1]);
    }
}
