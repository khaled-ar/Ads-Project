<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Notifications\EmailVerificationCode;
use Illuminate\Foundation\Http\FormRequest;

class ResendCodeRequest extends FormRequest
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
            'username' => ['required', 'string', 'exists:users,username']
        ];
    }

    public function resend() {
        $user = User::whereUsername($this->username)->first();
        $user->notify(new EmailVerificationCode());
        return 'The code has been resent successfully.';
    }
}
