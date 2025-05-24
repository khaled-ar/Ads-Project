<?php

namespace App\Http\Requests\Dashboard\Lables;

use App\Models\Lable;
use Illuminate\Foundation\Http\FormRequest;

class StoreLableRequest extends FormRequest
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
            'type' => ['required', 'string', 'max:100'],
        ];
    }

    public function store() {
        Lable::create($this->validated());
        return 'Lable Created Suuccessfully.';
    }
}
