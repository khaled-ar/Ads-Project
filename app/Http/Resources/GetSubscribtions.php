<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetSubscribtions extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'driver_id' => $this->driver->id,
            'status' => $this->status,
            'driver_name' => $this->driver->fullname,
            'driver_image_url' => $this->driver->user->image_url,
        ];
    }
}
