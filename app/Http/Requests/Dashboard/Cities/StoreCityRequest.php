<?php

namespace App\Http\Requests\Dashboard\Cities;

use App\Models\City;
use Illuminate\Foundation\Http\FormRequest;

class StoreCityRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100', 'unique:cities,name'],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function store() {
        City::create($this->validated());
        return 'City Created Suuccessfully.';
    }
}
