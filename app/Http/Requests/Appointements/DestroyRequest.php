<?php

namespace App\Http\Requests\Appointements;

use App\Notifications\DatabaseNotification;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class DestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = request()->user();
        if($user->role == 'سائق') {
            return in_array(request()->appointment->id, $user->driver->appointments()->pluck('id')->toArray());
        }
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
            'notes' => ['nullable', 'string', 'max:1000']
        ];
    }

    public function cancle($appointement) {
        return DB::transaction(function() use ($appointement){
            $appointement->forceFill(['status' => 'canceled']);
            $appointement->update(['notes' => $this->notes]);
            $appointement->save();

            $driver = $appointement->driver->user;
            $subject = "الغاء الموعد";
            $body = "لقد تم الغاء الموعد الخاص بك، اسم الاعلان: {$appointement->ad->name}";
            if($appointement->notes) {
                $body .= " ملاحظات، {$appointement->notes}";
            }
            $driver->notify(new DatabaseNotification($body, $subject, 'appointment_canceled'));
            return $appointement->id;
        });
    }
}
