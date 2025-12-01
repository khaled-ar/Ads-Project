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
            'username' => ['required', 'string', 'exists:users,username'],
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
        $user = User::whereUsername($this->username)->first() ?? null;
        $user_data = Cache::get($user->email ?? $user->driver->number) ?? null;
        if($this->code !== $user_data) {
            return $this->generalResponse(null, 'Please Ckeck the Code Again', 400);
        }
        $user->update(['password' => $this->password]);
        Cache::forget($user->email ?? $user->driver->number);
        return $this->generalResponse(null, 'Password Changed Successfully', 200);

    }
}
