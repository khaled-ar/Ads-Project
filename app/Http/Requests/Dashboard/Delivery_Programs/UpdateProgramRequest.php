<?php

namespace App\Http\Requests\Dashboard\Delivery_Programs;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProgramRequest extends FormRequest
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
        ];
    }

    public function update($program)
    {
        $program->update($this->validated());
        return 'Delivery Program Updated Suuccessfully.';
    }
}
