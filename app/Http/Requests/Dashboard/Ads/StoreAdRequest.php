<?php

namespace App\Http\Requests\Dashboard\Ads;

use App\Models\Ad;
use Illuminate\Foundation\Http\FormRequest;
use App\Services\QrService;
use Illuminate\Support\Facades\DB;

class StoreAdRequest extends FormRequest
{
    public function __construct(private QrService $qr) {}
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
            'duration' => ['required', 'string'],
            'centers' => ['required', 'string', 'max:1000'],
            'images' => ['required', 'array', 'between:1,10'],
            'images.*' => ['image', 'mimes:png,jpg', 'max:4096'],
            'country' => ['required', 'string', 'exists:countries,name'],
            'city' => ['required', 'string', 'exists:cities,name'],
            'steps_sum' => ['required', 'numeric'],
            'user_id' => ['required', 'integer', 'exists:users,id']
        ];
    }

    public function store()
    {
        return DB::transaction(function () {
            $data = $this->except('images');
            $data['images'] = '';
            $ad = Ad::create($data);
            $ad->update(['status' => 'قيد العمل']);
            $this->qr->generateQrCode($ad);
            return $ad->id;
        });
    }
}
