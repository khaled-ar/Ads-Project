<?php

namespace App\Http\Resources\Dashboard\Drivers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DriverResource extends ResourceCollection
{
    public function __construct(private Driver $driver) {}

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->driver->id,
            'username' => $this->driver->user->username,
            'role' => $this->driver->user->role,
            'account_status' => $this->driver->user->account_status,
            'place_of_residence' => $this->driver->place_of_residence,
            'work_status' => $this->driver->work_status,
            'age' => $this->driver->age,
            'number' => $this->driver->number,
            'nationality' => $this->driver->nationality,
            'gender' => $this->driver->gender,
            'car_name' => $this->driver->car_name,
            'car_color' => $this->driver->car_color,
            'car_number' => $this->driver->car_number,
            'car_year' => $this->driver->car_year,
            'file_url' => $this->driver->file_url,
        ];
    }
}
