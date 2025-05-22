<?php

namespace App\Http\Requests\Appointments;

use App\Models\{
    Ad,
    Appointment,
    Center,
    User,
};
use App\Notifications\DatabaseNotification;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return request()->user()->role == 'سائق';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'center_id' => ['required', 'integer', 'exists:centers,id'],
            'ad_id' =>     ['required', 'integer', 'exists:ads,id'],
            'date_time' => ['required', 'string']
        ];
    }

    public function store() {
        return DB::transaction(function() {
            $driver_id = $this->user()->driver->id;
            $this->merge(['driver_id' => $driver_id]);
            $appointment = Appointment::create($this->all());
            $admin = User::whereRole('ادمن')->first();
            $subject = "لقد تم حجز موعد جديد، يرجى الاطلاع";
            $body = "معرف الموعد {$appointment->id}, معرف السائق {$driver_id}";
            $admin->notify(new DatabaseNotification($body, $subject, 'new_appointment'));
            return $appointment->id;
        });
    }

    public function check_centers($ad_id, $center_id) {
        $center = Center::whereId($center_id)->first();
        $ad = Ad::whereId($ad_id)->first(['centers', 'created_at']);
        $centers = explode('،', $ad->centers);
        return in_array($center->name, $centers);
    }
}
