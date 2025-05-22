<?php

namespace App\Http\Requests\Dashboard\Cars;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:100'],
            'year' => ['nullable', 'integer', 'digits:4'],
        ];
    }

    public function update($car) {
        $car->update($this->validated());
        return 'Car Updated Suuccessfully.';
    }
}
