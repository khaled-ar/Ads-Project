<?php

namespace App\Http\Requests\Dashboard\Centers;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCenterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['string', 'unique:centers,name,' . $this->center->id . ',id'],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'location' => ['nullable', 'string'],
        ];
    }

    public function update($center) {
        $center->update($this->all());
    }
}
