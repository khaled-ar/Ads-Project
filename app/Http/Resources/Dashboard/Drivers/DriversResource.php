<?php

namespace App\Http\Resources\Dashboard\Drivers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriversResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'fullname' => $this->driver->fullname,
            'role' => $this->role,
            'account_status' => $this->account_status,
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
