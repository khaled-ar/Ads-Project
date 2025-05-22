<?php

namespace App\Http\Requests\Dashboard\Cars;

use App\Models\Car;
use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
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
            'year' => ['required', 'integer', 'digits:4'],
        ];
    }

    public function store() {
        Car::create($this->validated());
        return 'Car Created Suuccessfully.';
    }
}
