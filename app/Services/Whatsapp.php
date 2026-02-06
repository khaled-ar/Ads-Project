<?php

namespace App\Services;

use Illuminate\Support\Facades\{
    Cache,
    Http,
    Log
};

class Whatsapp {

    public static function send_code($number) {
        $code = substr(str_shuffle('0123456789'), 0, 6);
        $base_url = config('services.whatsapp_base_url');
        $whatsapp_api_v1 = config('services.whatsapp_api_v1');
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            // 'Content-Type' => 'application/json',
            'Authorization' => "Bearer " . config('services.whatsapp_access_token')
        ])
        ->post("{$base_url}/{$whatsapp_api_v1}/message/text/send", [
            'session_id' => config('services.whatsapp_session_id'),
            'receiver' => $number,
            'text' => "رمز التحقق الخاص بك هو: {$code} لا تشاركه مع احد، علما انه صالح لمدة خمس دقائق فقط",
        ]);
        if ($response->successful()) {
            Cache::put($number, $code, 60 * 5);
            return true;
        }
        Log::error($response->body());
    }

}
