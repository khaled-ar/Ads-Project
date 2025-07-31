<?php

namespace App\Http\Requests\Dashboard\Ads;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdRequest extends FormRequest
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
            'name' => ['string', 'max:100', 'unique:ads,name,' . request()->dash_ad->id . ',id'],
            'description' => ['string', 'max:1000'],
            'terms' => ['string', 'max:1000'],
            'drivers_number' => ['integer', 'min:1'],
            'budget' => ['numeric'],
            'km_price' => ['numeric'],
            'km_min' => ['numeric', 'min:1'],
            'km_max' => ['numeric', 'gt:km_min'],
            'company_name' => ['string', 'max:100'],
            'regions' => ['string', 'max:100'],
            // 'duration' => ['integer', 'min:1'],
            'centers' => ['string', 'max:1000'],
            'status' => ['string', 'in:قيد العمل,منتهية'],
        ];
    }
}
