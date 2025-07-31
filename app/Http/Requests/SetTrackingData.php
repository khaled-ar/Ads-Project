<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetTrackingData extends FormRequest
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
            'driver_id' => ['required', 'integer', 'exists:drivers,id'],
            'ad_id' => ['required', 'integer', 'exists:ads,id'],
            'distance' => ['required'],
            'traffic' => ['required', 'string', 'in:high,medium,low,empty'],
            'time' => ['required', 'string', 'in:peak,medium,low,empty'],
            'sector' => ['required', 'string', 'in:main,medium,secondary,none'],
        ];
    }
}
