<?php

namespace App\Http\Requests\Dashboard\Centers;

use App\Models\Center;
use Illuminate\Foundation\Http\FormRequest;

class StoreCenterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:200', 'unique:centers,name'],
            'location' => ['required', 'string', 'max:1000'],
            'work_times' => ['required', 'string', 'max:1000'],
            'status' => ['string', 'in:مغلق,مفتوح'],
        ];
    }

    public function store() {
        Center::create($this->all());
    }
}
