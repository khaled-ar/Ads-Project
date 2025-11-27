<?php

namespace App\Http\Requests\Dashboard\Countries;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCountryRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:100', 'unique:countries,name'],
        ];
    }

    public function update($country) {
        $country->update($this->validated());
        return 'Country Updated Suuccessfully.';
    }
}
