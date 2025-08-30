<?php

namespace App\Console;

use App\Jobs\CalculateDriversProfits;
use App\Jobs\DeleteRejectedDrivers;
use App\Jobs\SaveCoordinates;
use App\Jobs\UpdateAdStatus;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new SaveCoordinates())->everyFiveMinutes();
        $schedule->job(new UpdateAdStatus())->everySecond()->then(function() {
            CalculateDriversProfits::dispatch();
        });
        $schedule->job(new DeleteRejectedDrivers())->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
