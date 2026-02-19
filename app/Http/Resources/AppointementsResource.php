<?php

namespace App\Http\Resources;

use App\Models\Appointement;
use App\Models\Center;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointementsResource extends JsonResource
{
    public function __construct(private Center $center) {}

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $works_days = $this->center->works_days;
        $center_name = $this->center->name;
        $center_location = $this->center->location;

        foreach ($works_days as $day) {
            $all_times = []; 

            foreach ($day->works_times as $time) {
                $times = $this->generateTimeRange($time->start, $time->end);
                $all_times = array_merge($all_times, $times);
            }

            $appointments = Appointement::where('works_days_id', $day->id)
                ->where('center_id', $this->center->id)
                ->where('status', '<>', 'canceled')
                ->pluck('time')
                ->toArray();

            $available_times = array_diff($all_times, $appointments);

            $day->available_times = array_values($available_times);
            unset($day->works_times);
        }

        return [
            'center_name' => $center_name,
            'center_location' => $center_location,
            'works_days' => $works_days,
        ];
    }

    /**
     * Generate time range between start and end times
     *
     * @param string $startTime Start time in format "H:i" (e.g., "10:30")
     * @param string $endTime End time in format "H:i" (e.g., "16:30")
     * @return array
     */
    function generateTimeRange($startTime, $endTime)
    {
        $times = [];

        $start_parts = explode(':', $startTime);
        $end_parts = explode(':', $endTime);

        $start_hour = (int)$start_parts[0];
        $start_minute = (int)($start_parts[1] ?? 0);

        $end_hour = (int)$end_parts[0];
        $end_minute = (int)($end_parts[1] ?? 0);

        if ($end_hour < $start_hour && $end_hour < 12) {
            $end_hour += 12;
        }

        if ($start_hour > 12 && $end_hour < $start_hour && $end_hour < 12) {
            $end_hour += 24;
        }

        $start = Carbon::createFromTime($start_hour, $start_minute, 0);
        $end = Carbon::createFromTime($end_hour, $end_minute, 0);

        if ($end->lessThan($start)) {
            $end->addDay();
        }

        while ($start->lessThan($end)) {
            $times[] = $start->format('g:i A');
            $start->addHour();
        }

        return $times;
    }
}
