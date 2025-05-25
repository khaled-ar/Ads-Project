<?php

namespace App\Http\Requests\Drivers;

use App\Models\User;
use App\Notifications\DatabaseNotification;
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
            //
        ];
    }

    public function store($ad) {

        return DB::transaction(function() use($ad){
            $driver = $this->user();
            if($driver->driver->activeAdsNumber()) {
                return ['You cannot subscribe in this ad because you already has subscribtion.', 400];
            }

            $driver->driver->ads()->create(['ad_id' => $ad->id, 'profits' => 0]);
            $admin = User::whereRole('ادمن')->first();
            $body = "لقد قام {$driver->username} بتقديم طلب انضمام الى الحملة {$ad->name}";
            $subject = 'طلب انضمام جديد';
            Notification::send([$admin, $ad->user], new DatabaseNotification($body, $subject, 'new_subscribtion'));
            return ['Subscribtion Requested Successfully, Please Wait for Admin Approval.', 201];
        });
    }


}
