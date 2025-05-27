<?php

namespace App\Http\Requests\Dashboard\WorksDays;

use App\Models\WorksDays;
use Illuminate\Foundation\Http\FormRequest;

class StoreWorkDayRequest extends FormRequest
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
            'center_id' => ['required', 'integer', 'exists:centers,id'],
            'day' => ['required', 'string'],
        ];
    }

    public function store() {
        WorksDays::create($this->all());
    }
}
