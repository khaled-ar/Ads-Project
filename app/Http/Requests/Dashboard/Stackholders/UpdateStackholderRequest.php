<?php

namespace App\Http\Requests\Dashboard\Stackholders;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateStackholderRequest extends FormRequest
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
            'username' => ['string', 'between:3,15', 'unique:users,username'],
            'email' => ['email', 'unique:users,email'],
            'password' => ['string',
                Password::min(8)
                    ->max(25)
                    ->numbers()
                    ->symbols()
                    ->mixedCase()
                    ->uncompromised()
                ],
            'company_representative' => ['string'],
            'location' => ['string'],
            'number' => ['string'],
            'commercial_number' => ['string']
        ];
    }

    public function update($user) {
        $user_data = $this->only(['username', 'password', 'email']);
        $company_data = $this->only(['location', 'number', 'commercial_number', 'company_representative']);
        $user->update($user_data);
        $user->stackholder()->update($company_data);
        return 'Stackholder Account Updated Successfully.';
    }
}
