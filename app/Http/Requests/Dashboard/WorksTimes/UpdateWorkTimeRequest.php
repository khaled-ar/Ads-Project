<?php

namespace App\Http\Requests\Dashboard\WorksTimes;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkTimeRequest extends FormRequest
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
            'works_days_id' => ['nullable', 'integer', 'exists:works_days,id'],
            'start' => ['nullable', 'string'],
            'end' => ['nullable', 'string'],
        ];
    }

    public function update($works_time) {
        $works_time->update($this->all());
    }
}
