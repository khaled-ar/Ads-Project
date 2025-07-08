<?php

namespace App\Services;

use App\Models\Coordinate;
use Illuminate\Support\Facades\Cache;

class GPS {

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
}
