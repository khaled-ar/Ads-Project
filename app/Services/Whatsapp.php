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

        $response = Http::withoutVerifying()->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'x-api-key' => config('services.whatsapp_api_key')
        ])
        ->post('https://staging.hypermsg.net/api/whatsapp/send-message', [
            'whatsapp_number_id' => 12,
            'phone_number' => $number,
            'message' => "رمز التحقق الخاص بك هو: {$code} لا تشاركه مع احد، علما انه صالح لمدة خمس دقائق فقط",
        ]);
        if ($response->successful()) {
            Cache::put($number, $code, 60 * 5);
            return true;
        }
        Log::error($response->body());
    }

}
