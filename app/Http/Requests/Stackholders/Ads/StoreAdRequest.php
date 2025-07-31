<?php

namespace App\Http\Requests\Stackholders\Ads;

use App\Models\{
    Ad,
    User
};
use App\Notifications\DatabaseNotification;
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
            'terms' => ['required', 'string', 'max:1000'],
            'drivers_number' => ['required', 'integer', 'min:1'],
            'budget' => ['required', 'numeric'],
            'km_price' => ['required', 'numeric'],
            'km_min' => ['required', 'numeric', 'min:1'],
            'km_max' => ['required', 'numeric', 'gt:km_min'],
            'company_name' => ['required', 'string', 'max:100'],
            'regions' => ['required', 'string', 'max:100'],
            'duration' => ['required', 'integer', 'min:1'],
            'centers' => ['required', 'string', 'max:1000'],
            'images' => ['required', 'array', 'between:1,10'],
            'images.*' => ['image', 'mimes:png,jpg', 'max:4096'],
        ];
    }

    public function store() {
        return DB::transaction(function() {
            $data = $this->except('images');
            $data['images'] = '';
            $ad = Ad::create($data);
            $admin = User::whereRole('ادمن')->first();
            $body = "لقد تمت عملية اضافة اعلان جديد من خلال: {$ad->user->username}";
            $subject = 'لديك اعلان جديد';
            $admin->notify(new DatabaseNotification($body, $subject, 'new_ad'));
            return $ad->id;
        });
    }
}
