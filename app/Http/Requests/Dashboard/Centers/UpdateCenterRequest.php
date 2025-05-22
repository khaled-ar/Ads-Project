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
            'name' => ['string', 'max:200', 'unique:centers,name,' . $this->center->id . ',id'],
            'location' => ['string', 'max:1000'],
            'work_times' => ['string', 'max:1000'],
            'status' => ['string', 'in:مغلق,مفتوح'],
        ];
    }

    public function update($center) {
        $center->update($this->all());
    }
}
