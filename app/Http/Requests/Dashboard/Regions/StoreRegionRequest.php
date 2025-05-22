<?php

namespace App\Http\Requests\Dashboard\Regions;

use App\Models\Region;
use Illuminate\Foundation\Http\FormRequest;

class StoreRegionRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
            'city_id' => ['required', 'integer', 'exists:cities,id']
        ];
    }

    public function store() {
        Region::create($this->validated());
        return 'Region Created Suuccessfully.';
    }
}
