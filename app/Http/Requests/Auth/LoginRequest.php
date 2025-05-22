<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginRequest extends FormRequest
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
            'username' => ['required', 'string'],
            'password' => ['required', 'string']
        ];
    }

    public function authenticate()
    {
        return Auth::attempt(
            [
                'username' => $this->username,
                'password' => $this->password,
            ]
        );
    }

    public function getData() {
        $user = User::whereUsername($this->username)->first();
        $user['token'] = $user->createToken($user->username)->plainTextToken;
        if($user->role == 'سائق') {
            $user->load('driver.ads');
        }

        return $user;
    }
}
