<?php

namespace App\Http\Requests\Dashboard\Subscribtions;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\DriverAd;
use App\Notifications\DatabaseNotification;
use App\Notifications\FcmNotification;
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
            $driver_ad->forceFill(['status' => 'appointement_booking'])->save();
            $driver = $driver_ad->driver;
            $body = "لقد تم قبول طلب انضمامك الى الحملة الاعلانية، خلال مدة اقصاها 24 ساعة، يرجى التوجه الى تفاصيل الحملة من اجل حجز موعد تلزيق اللصاقات: {$driver_ad->ad->name}";
            $subject = 'طلب الانضمام الى الحملة الاعلانية';
            $driver->user->notify(new FcmNotification($subject, $body));
            $driver->user->notify(new DatabaseNotification($body, $subject, 'joining_approved'));
            $driver->ads()->whereStatus('approval_wating')->delete();
        });
    }
}
