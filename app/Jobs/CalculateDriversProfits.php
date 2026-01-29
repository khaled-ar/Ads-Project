<?php

namespace App\Jobs;

use App\Models\DriverAd;
use App\Models\DriverTrip;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateDriversProfits implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $drivers_steps = DriverTrip::with(['ad', 'driver'])->get();
            foreach ($drivers_steps as $driver_steps) {
                $km_min = $driver_steps->ad->km_min;
                $km_price = $driver_steps->ad->km_price;
                if ($driver_steps->steps < $km_min) {
                    $steps = 0;
                } else {
                    $steps = $driver_steps->steps;
                }
                $profits = round($steps * $km_price, 2);
                DriverAd::whereAdId($driver_steps->ad_id)
                    ->whereDriverId($driver_steps->driver_id)
                    ->update([
                        'profits' => $profits
                    ]);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
