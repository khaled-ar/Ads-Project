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

        foreach($works_days as $day) {
            foreach($day->works_times as $time) {
                $start = (int)(explode(':', $time->start)[0]);
                $end = (int)(explode(':', $time->end)[0]);
                $times = $this->generateTimeRange($start, $end-1);
            }
            // Fetch appointments for the current day and center
            $appointments = Appointement::where('works_days_id', $day->id)
                ->where('center_id', $this->center->id)
                ->where('status', '<>', 'canceled')
                ->pluck('time')
                ->toArray();

            $available_times = array_diff($times, $appointments);

            // Assign available times back to the day object
            $day->available_times = array_values($available_times);
            unset($day->works_times);
        }

        return [
            'center_name' => $center_name,
            'center_location' => $center_location,
            'works_days' => $works_days,
        ];
    }

    function generateTimeRange($startHour, $endHour)
    {
        $times = [];

        $startTime = Carbon::createFromFormat('g A', "$startHour AM");
        $endTime = Carbon::createFromFormat('g A', "$endHour PM");

        while ($startTime->lessThanOrEqualTo($endTime)) {
            $times[] = $startTime->format('g:i A');
            $startTime->addHour();
        }

        return $times;
    }
}

