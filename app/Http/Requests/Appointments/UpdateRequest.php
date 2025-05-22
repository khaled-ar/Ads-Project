<?php

namespace App\Http\Requests\Appointments;

use App\Notifications\DatabaseNotification;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return request()->user()->role == 'ادمن';
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

    public function update($appointment) {
        return DB::transaction(function() use ($appointment){
            $appointment->forceFill(['status' => 'مجدول'])->save();
            $driver = $appointment->driver->user;
            $subject = "لقد تمت الموافقة على حجز موعد جديد، يرجى الاطلاع";
            $body = "معرف الموعد {$appointment->id}, اسم المركز {$appointment->center->name}";
            $driver->notify(new DatabaseNotification($body, $subject, 'appointment_approval'));
            return $appointment->id;
        });
    }
}
