<?php

namespace App\Http\Requests\Stackholders\ads;

use App\Models\User;
use App\Notifications\DatabaseNotification;
use App\Notifications\FcmNotification;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UpdateAdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return in_array(request()->ad->id, request()->user()->ads()->pluck('id')->toArray());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'unique:ads,name,' . request()->ad->id . ',id'],
            'description' => ['string'],
            'terms' => ['string'],
            'drivers_number' => ['integer', 'min:1'],
            'budget' => ['numeric'],
            'km_price' => ['numeric'],
            'km_min' => ['numeric', 'min:1'],
            'km_max' => ['numeric', 'gt:km_min'],
            'company_name' => ['string'],
            'regions' => ['string'],
            'centers' => ['string'],
            'status' => ['string', 'in:قيد العمل,منتهية']
        ];
    }

    public function update($ad) {
        return DB::transaction(function() use ($ad) {
            $data = $this->except('images');
            $ad->update($data);
            $notifiables = User::whereRole('ادمن')->get();
            $body = "لقد قام {$ad->user->username} بتعديل الاعلان رقم {$ad->id}";
            $subject = 'تعديل اعلان';
            foreach($notifiables as $notifiable) {
                $notifiable->notify(new FcmNotification($subject, $body));
                $notifiable->notify(new DatabaseNotification($body, $subject, 'ad_edition'));
            }
            return $ad->id;
        });
    }
}
