<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\Coordinate;
use App\Models\DriverAd;
use App\Models\DriverTrip;
use Illuminate\Support\Facades\Cache;

class GPS {

    const TRAFFIC_HIGH = 1.0;
    const TRAFFIC_MEDIUM = 0.5;
    const TRAFFIC_LOW = 0.25;
    const TRAFFIC_EMPTY = 0.01;

    const TIME_PEAK = 1.0;
    const TIME_MEDIUM = 0.5;
    const TIME_LOW = 0.25;
    const TIME_EMPTY = 0.01;

    const SECTOR_MAIN = 1.0;
    const SECTOR_MEDIUM = 0.5;
    const SECTOR_SECONDARY = 0.25;
    const SECTOR_NONE = 0.01;

    public function set($id, $lat, $lon) {
        return Cache::set($id, ['lat' => $lat, 'lon' => $lon]);
    }

    public function get($id) {
        $cache = $this->check_cache($id);
        if($cache) {
            return $cache;
        }
        $coordinates = Coordinate::whereUserId($id)->first(['lat', 'lon']);
        return $coordinates;
    }

    public function check_cache($id) {
        return Cache::get($id);
    }

    public function set_data($driver_id, $ad_id, $distance, $traffic, $time, $sector) {
        $tts = $this->match_tts($traffic, $time, $sector);
        $steps = ($distance / 1000) * $tts['traffic'] * $tts['time'] * $tts['sector'];
        $driver_trip = DriverTrip::whereDriverId($driver_id)
            ->whereAdId($ad_id)
            ->first();

        if(! $driver_trip) {
            DriverTrip::create([
                'driver_id' => $driver_id, 'ad_id' => $ad_id,
                'distance' => $distance, 'steps' => $steps,
                'km_count' => $distance / 1000,
            ]);

        } else {
            $km_max = Ad::whereId($ad_id)->first()->km_max;
            if($driver_trip->steps >= $km_max) {
                return ['The Steps Count Reached To The Maximum Value.', 400];
            }

            $driver_trip->increment('distance', $distance);
            $driver_trip->increment('steps', $steps);
            $driver_trip->increment('km_count', $distance / 1000);
            $driver_trip->save();
        }

        $driver_ad = DriverAd::whereDriverId($driver_id)
            ->whereAdId($ad_id)
            ->first();
        $driver_ad->increment('steps', $steps);

        return ['Tracking Data Saved Successfully.', 200, round($driver_ad->steps, 2)];
    }

    public function match_tts($traffic, $time, $sector) {
        $tts = [
            'traffic' => 0,
            'time' => 0,
            'sector' => 0,
        ];

        if($traffic == 'high')
            $tts['traffic'] = static::TRAFFIC_HIGH;
        elseif($traffic == 'medium')
            $tts['traffic'] = static::TRAFFIC_MEDIUM;
        elseif($traffic == 'low')
            $tts['traffic'] = static::TRAFFIC_LOW;
        else
            $tts['traffic'] = static::TRAFFIC_EMPTY;


        if($time == 'peak')
            $tts['time'] = static::TIME_PEAK;
        elseif($time == 'medium')
            $tts['time'] = static::TIME_MEDIUM;
        elseif($time == 'low')
            $tts['time'] = static::TIME_LOW;
        else
            $tts['time'] = static::TIME_EMPTY;


        if($sector == 'main')
            $tts['sector'] = static::SECTOR_MAIN;
        elseif($sector == 'medium')
            $tts['sector'] = static::SECTOR_MEDIUM;
        elseif($sector == 'secondary')
            $tts['sector'] = static::SECTOR_SECONDARY;
        else
            $tts['sector'] = static::SECTOR_NONE;

        return $tts;
    }
}
