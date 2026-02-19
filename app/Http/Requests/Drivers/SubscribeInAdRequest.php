<?php

namespace App\Http\Requests\Drivers;

use App\Models\User;
use App\Notifications\DatabaseNotification;
use App\Notifications\FcmNotification;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\{
    DB,
    Notification
};

class SubscribeInAdRequest extends FormRequest
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
            'lables' => ['required', 'string']
        ];
    }

    public function store($ad) {

        return DB::transaction(function() use($ad){
            $driver = $this->user();
            if($driver->driver->activeAdsNumber()) {
                return ['You cannot subscribe in this ad because you already has subscribtion.', 400];
            }

            $driver->driver->ads()->create(['ad_id' => $ad->id, 'profits' => 0, 'lables' => $this->lables]);
            $admins = User::whereRole('ادمن')->get();
            $body = "لقد قام {$driver->driver->fullname} بتقديم طلب انضمام الى الحملة {$ad->name}";
            $subject = 'طلب انضمام جديد';
            $notifiables = $admins->push($ad->user);
            foreach($notifiables as $notifiable) {
                $notifiable->notify(new FcmNotification($subject, $body));
            }
            Notification::send($notifiables, new DatabaseNotification($body, $subject, 'new_subscribtion'));
            return ['Subscribtion Requested Successfully, Please Wait for Admin Approval.', 201];
        });
    }

}
