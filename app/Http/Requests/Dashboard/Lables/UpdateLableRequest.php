<?php

namespace App\Http\Requests\Dashboard\Lables;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLableRequest extends FormRequest
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
            'type' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function update($lable) {
        $lable->update($this->validated());
        return 'Lable Updated Suuccessfully.';
    }
}
