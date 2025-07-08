<?php

namespace App\Jobs;

use App\Models\Coordinate;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SaveCoordinates implements ShouldQueue
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
            $users = User::all(['id']);
            foreach ($users as $user) {
                $cache = Cache::get($user->id);
                if ($cache) {
                    Coordinate::updateOrCreate([
                        'user_id'   => $user->id,
                    ], [
                        'id' => (string)Str::uuid(),
                        'lat' => $cache['lat'],
                        'lon' => $cache['lon'],
                    ]);
                    Cache::forget($user->id);
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
