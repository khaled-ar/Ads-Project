<?php

namespace App\Http\Requests\Stackholders\Ads;

use App\Models\{
    Ad,
    User
};
use App\Notifications\DatabaseNotification;
use App\Notifications\FcmNotification;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class StoreAdRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100', 'unique:ads,name'],
            'description' => ['required', 'string', 'max:1000'],
            'budget' => ['required', 'numeric'],
            'country' => ['required', 'string', 'exists:countries,name'],
            'city' => ['required', 'string', 'exists:cities,name'],
            'regions' => ['required', 'string'],
            'duration' => ['required', 'string'],
            'images' => ['required', 'array', 'between:1,10'],
            'images.*' => ['image', 'mimes:png,jpg', 'max:4096'],
        ];
    }

    public function store() {
        return DB::transaction(function() {
            $data = $this->except('images');
            $data['images'] = '';
            $ad = Ad::create($data);
            $notifiables = User::whereRole('ادمن')->get();
            $body = "لقد تمت عملية اضافة اعلان جديد من خلال: {$ad->user->username}";
            $subject = 'لديك اعلان جديد';
            foreach($notifiables as $notifiable) {
                $notifiable->notify(new FcmNotification($subject, $body));
                $notifiable->notify(new DatabaseNotification($body, $subject, 'new_ad'));
            }
            return $ad->id;
        });
    }
}
