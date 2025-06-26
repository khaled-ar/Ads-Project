<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;


class QrService
{
    public function generateQrCode($ad)
    {
        // Create directory if it doesn't exist with proper permissions
        $directory = public_path('QrCodes');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Create a simple filename using just the ad_id
        $filename = 'qr_' . $ad->id . '.svg';
        $path = $directory . '/' . $filename;

        QrCode::format('svg')
            ->size(400)
            ->gradient(10, 60, 150, 150, 60, 10, 'vertical') // Blue to orange gradient
            ->style('round')
            ->eye('circle')
            ->margin(10)
            ->encoding('UTF-8')
            ->errorCorrection('H')
            ->generate($ad, $path);
    }
}
