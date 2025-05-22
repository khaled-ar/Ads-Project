<?php

namespace App\Http\Requests\Dashboard\Subscribtions;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\DriverAd;
use App\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\DB;

class JoiningApproveRequest extends FormRequest
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

    public function approve($id) {
        DB::transaction(function() use($id) {
            $driver_ad = DriverAd::findOrFail($id);
            $driver_ad->forceFill(['status' => 'in_progress'])->save();
            $driver = $driver_ad->driver;
            $body = "لقد تم قبول طلب انضمامك الى الحملة الاعلانية: {$driver_ad->ad->name}";
            $subject = 'طلب الانضمام الى الحملة الاعلانية';
            $driver->user->notify(new DatabaseNotification($body, $subject, 'joining_approvel'));
        });
    }
}
