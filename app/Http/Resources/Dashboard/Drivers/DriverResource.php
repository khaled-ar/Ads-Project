<?php

namespace App\Http\Resources\Dashboard\Drivers;

use App\Models\Driver;
use App\Models\DriverTrip;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DriverResource extends ResourceCollection
{
    public function __construct(private Driver $driver, private string $lables) {}

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->driver->id,
            'user_id' => $this->driver->user_id,
            'username' => $this->driver->user->username,
            'account_status' => $this->driver->user->account_status,
            'place_of_residence' => $this->driver->place_of_residence,
            'work_status' => $this->driver->work_status,
            'birth_date' => $this->driver->birth_date,
            'number' => $this->driver->number,
            'nationality' => $this->driver->nationality,
            'km_per_day' => $this->driver->km_per_day,
            'km_per_month' => $this->driver->km_per_month,
            'gender' => $this->driver->gender,
            'car_model' => $this->driver->car_model,
            'car_color' => $this->driver->car_color,
            'car_number' => $this->driver->car_number,
            'car_year' => $this->driver->car_year,
            'personal_id_image_url' => $this->driver->personal_id_image_url,
            'driving_license_image_url' => $this->driver->driving_license_image_url,
            'car_mechanics_image_url' => $this->driver->personal_id_image_url,
            'lables' => $this->lables,
            'total_steps' => DriverTrip::whereAdId(request('ad_id'))->whereDriverId($this->driver->id)->first()->steps,
            'appointement' => $this->driver->appointement,
        ];
    }
}
