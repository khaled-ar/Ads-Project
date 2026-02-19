<?php

namespace App\Http\Resources\Dashboard\Centers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetSingleCenter extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $appointements = $this->appointements;
        $new_appointements = [];
        foreach($appointements as $appointement) {
            $new_appointements[] = [
                'day' => $appointement->work_day->day,
                'time' => $appointement->time,
                // 'status' => $appointement->status,
                'driver_name' => $appointement->driver->fullname,
                'driver_image_url' => $appointement->driver->user->image_url,
            ];
        }

        return [
            'center_name' => $this->name,
            'center_location' => $this->location,
            'city' => $this->city,
            'appointements' => $new_appointements,
            'works_days' => $this->works_days
        ];
    }
}
