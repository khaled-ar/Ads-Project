<?php

namespace App\Jobs;

use App\Models\Ad;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateAdStatus implements ShouldQueue
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
        $ads = Ad::with('drivers')->whereStatus('قيد العمل')->get();
        foreach($ads as $ad) {
            if(Carbon::make(explode(',', $ad->duration)[1]) <= now()) {
                $ad->update([
                    'status' => 'منتهية'
                ]);
                $ad->drivers()->update([
                    'status' => 'done'
                ]);
            }
        }
    }
}
