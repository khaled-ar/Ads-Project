<?php

namespace App\Jobs;

use App\Models\Ad;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
            if($ad->created_at->addDays($ad->duration) <= now()) {
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
