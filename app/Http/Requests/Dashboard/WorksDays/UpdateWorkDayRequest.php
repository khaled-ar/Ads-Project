<?php

namespace App\Http\Requests\Dashboard\WorksDays;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkDayRequest extends FormRequest
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
            'center_id' => ['nullable', 'integer', 'exists:centers,id'],
            'day' => ['nullable', 'string'],
        ];
    }

    public function update($work_day) {
        $work_day->update($this->all());
    }
}
