<?php

namespace App\Http\Requests\Dashboard\Cities;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCityRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:100', 'unique:cities,name,'. $this->city->id .',id'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function update($city) {
        $city->update($this->validated());
        return 'City Updated Suuccessfully.';
    }
}
