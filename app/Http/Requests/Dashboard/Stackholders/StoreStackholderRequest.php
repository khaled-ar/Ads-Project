<?php

namespace App\Http\Requests\Dashboard\Stackholders;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreStackholderRequest extends FormRequest
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
            'email' => ['required', 'email', 'unique:users,email'],
            'username' => ['required', 'string', 'unique:users,username'],
            'image' => ['nullable', 'image', 'mimes:png,jpg', 'max:4096'],
            'password' => ['required', 'string',
                Password::min(8)
                    ->max(25)
                    ->numbers()
                    ->symbols()
                    ->mixedCase()
                    ->uncompromised()
                ]
        ];
    }

    public function store() {
        User::create(array_merge($this->validated(), [
            'ip_address' => $this->ip(),
            'role' => 'معلن'
        ]));
        return 'Stackholder Account Created Successfully.';
    }
}
