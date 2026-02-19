<?php

namespace App\Http\Requests\Appointements;

use App\Models\{
    Ad,
    Appointement,
    Center,
    User,
};
use Illuminate\Support\Facades\{
    DB,
    Notification,
};
use App\Notifications\DatabaseNotification;
use App\Notifications\FcmNotification;
use Illuminate\Foundation\Http\FormRequest;

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
            'ad_id' =>     ['required', 'integer', 'exists:ads,id'],
            'center_name' => ['required', 'string'],
            'works_days_id' => ['required', 'integer', 'exists:works_days,id'],
            'time' => ['required', 'string'],
        ];
    }

    public function store()
    {
        return DB::transaction(function () {
            $ad = Ad::whereId($this->ad_id)->with('user')->first();
            if(! $this->check_drivers_number($ad)){
                return ['Sorry, the required number of drivers has been reached. Please try again later. Thank you.', 403];
            }

            if(! $this->check_center($ad)){
                return ['Sorry, the selected center must be one of the available ad centers.', 400];
            }

            $driver_id = $this->user()->driver->id;
            $center_id = Center::whereName($this->center_name)->first()->id;
            $this->merge(['driver_id' => $driver_id, 'user_id' =>  $ad->user_id, 'center_id' => $center_id]);
            $appointment = Appointement::create($this->all());
            $appointment->ForceFill(['status' => 'to do'])->save();

            $admins = User::whereRole('ادمن')->get();
            $driver_name = $this->user()->driver->fullname;
            $subject = "لقد تم حجز موعد جديد، يرجى الاطلاع";
            $body = "نود اعلامك بان السائق {$driver_name} قام بحجز موعد في مركز {$this->center_name} في الساعة {$this->time} في اليوم {$appointment->work_day->day}";
            $notifiables = $admins->push($ad->user);
            foreach($notifiables as $notifiable) {
                $notifiable->notify(new FcmNotification($subject, $body));
            }
            Notification::send($notifiables, new DatabaseNotification($body, $subject, 'new_appointement'));
            return ['Your appointment has been booked successfully.', 201];
        });
    }


    public function check_center($ad)
    {
        return in_array($this->center_name, explode('،', $ad->centers));
    }

    public function check_drivers_number($ad) {
        $requested = $ad->drivers_number;
        $current = Appointement::whereAdId($ad->id)->whereStatus('to do')->count();
        return $current < $requested;
    }
}
