<?php

namespace App\Http\Requests\Appointements;

use App\Notifications\DatabaseNotification;
use App\Notifications\FcmNotification;
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
            $appointment->forceFill(['status' => 'to do'])->save();
            $driver = $appointment->driver->user;
            $subject = "لقد تمت الموافقة على حجز موعد جديد، يرجى الاطلاع";
            $body = 'يرجى التوجه الى المركز في الموعد المحدد، يمكنك الاطلاع على مواعيدك من خلال صفحة المواعيد الحاصة بك';
            $driver->notify(new DatabaseNotification($body, $subject, 'appointment_approval'));
            $driver->notify(new FcmNotification($subject, $body));
            return $appointment->id;
        });
    }
}
