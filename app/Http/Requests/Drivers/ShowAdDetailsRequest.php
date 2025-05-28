<?php

namespace App\Http\Requests\Drivers;

use App\Http\Resources\AppointementsResource;
use App\Models\Center;
use Illuminate\Foundation\Http\FormRequest;

class ShowAdDetailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function appointements($ad) {
        $ad->load('drivers.driver.user');
        $driver_ad = request()->user()->driver->ads()->whereAdId($ad->id)->first();
        if(! $driver_ad) {
            $ad['appointements'] = null;
            return $ad;
        }

        $centers = Center::whereIn('name', explode(',', $ad->centers))->get();
        $centers = AppointementsResource::collection($centers);
        $ad['appointements'] = $driver_ad->status == 'appointement_booking' ? $centers : null;
        return $ad;
    }
}
