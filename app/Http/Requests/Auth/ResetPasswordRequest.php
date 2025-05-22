<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rules\Password;
use App\Traits\Responses;

class ResetPasswordRequest extends FormRequest
{
    use Responses;
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
            'code' => ['required', 'string', 'size:6'],
            'password' => ['required', 'string', 'confirmed',
                Password::min(8)
                    ->max(25)
                    ->numbers()
                    ->symbols()
                    ->mixedCase()
                    ->uncompromised()
                ]
        ];
    }

    public function update_password() {
        $user_data = Cache::get(request()->ip());
        if(request()->code !== $user_data[1]) {
            return $this->generalResponse(null, 'Please Ckeck the Code Again', 400);
        }
        $user = User::whereEmail($user_data[0])->first();
        $user->update(['password' => $this->password]);
        Cache::forget(request()->ip());
        return $this->generalResponse(null, 'Password Changed Successfully', 200);

    }
}
