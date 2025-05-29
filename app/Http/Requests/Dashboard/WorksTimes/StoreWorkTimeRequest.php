<?php

namespace App\Http\Requests\Dashboard\WorksTimes;

use App\Models\WorksTimes;
use Illuminate\Foundation\Http\FormRequest;

class StoreWorkTimeRequest extends FormRequest
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
            'works_days_id' => ['required', 'integer', 'exists:works_days,id'],
            'start' => ['required', 'string'],
            'end' => ['required', 'string'],
        ];
    }

    public function store() {
        $time = WorksTimes::create($this->all());
        return ['work_time_id' => $time->id];
    }
}
