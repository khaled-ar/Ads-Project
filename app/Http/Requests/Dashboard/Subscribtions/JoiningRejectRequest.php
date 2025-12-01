<?php

namespace App\Http\Requests\Dashboard\Subscribtions;

use App\Models\DriverAd;
use App\Notifications\DatabaseNotification;
use App\Notifications\FcmNotification;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class JoiningRejectRequest extends FormRequest
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
            'notes' => ['required', 'string', 'max:1000']
        ];
    }

    public function reject($id) {
        DB::transaction(function() use($id) {
            $driver_ad = DriverAd::findOrFail($id);
            $driver = $driver_ad->driver;
            $body = "لقد تم رفض طلب انضمامك الى الحملة الاعلانية {$driver_ad->ad->name}";
            $subject = 'طلب الانضمام الى الحملة الاعلانية';
            $driver->user->notify(new FcmNotification($subject, $body));
            $driver->user->notify(new DatabaseNotification($body, $subject, 'joining_rejected', $this->notes));
            $driver_ad->delete();
        });
    }
}
