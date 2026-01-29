<?php

namespace App\Jobs;

use App\Models\Ad;
use App\Models\User;
use App\Notifications\DatabaseNotification;
use App\Notifications\FcmNotification;
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
            $start_end = explode(',', $ad->duration);
            if(Carbon::make($start_end[1]) <= now()) {
                $ad->update([
                    'status' => 'منتهية'
                ]);
                $ad->drivers()->update([
                    'status' => 'done'
                ]);
                $ad->user->notify(new FcmNotification('انتهاء حملة', "نود اعلامكم ان الحملة {$ad->name} قد انتهت"));
                $ad->user->notify(new DatabaseNotification("نود اعلامكم ان الحملة {$ad->name} قد انتهت", 'انتهاء حملة', 'ad_end'));
            } else {
                $start_date = Carbon::parse($start_end[0]);
                $end_date = Carbon::parse($start_end[1]);
                $now = Carbon::now();
                $total_duration = $start_date->diffInHours($end_date);
                $elapsed_duration = $start_date->diffInHours($now);
                $half_duration = $total_duration / 2;
                if ($elapsed_duration >= $half_duration) {
                    $ad->drivers()->get()->map(function($driver_ad) use($ad) {
                        if($driver_ad->steps < $ad->km_min) {
                            $driver_ad->driver->user->notify(new FcmNotification('تحذير', "نود اعلامكم ان الحملة {$ad->name} قد وصلت الى نصفها ولم يتم الوصول الى الحد الادنى لعدد الكيلومترات"));
                            $driver_ad->driver->user->notify(new DatabaseNotification("نود اعلامكم ان الحملة {$ad->name} قد وصلت الى نصفها ولم يتم الوصول الى الحد الادنى لعدد الكيلومترات", 'تحذير', 'ad_50'));
                        }
                    });
                }
            }
        }
    }
}
