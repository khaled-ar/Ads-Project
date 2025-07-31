<?php

namespace App\Jobs;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteRejectedDrivers implements ShouldQueue
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
        try{
            $drivers = User::whereRole('سائق')->whereAccountStatus('rejected')->get();
            foreach($drivers as $driver) {
                if(Carbon::parse($driver->rejected_at)->addDays(2) <= now()) {
                    $driver->delete();
                }
            }
        }catch(\Exception|\Throwable $e) {
            echo $e->getMessage();
        }
    }
}
