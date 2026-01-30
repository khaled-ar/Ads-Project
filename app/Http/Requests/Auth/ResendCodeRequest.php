<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Notifications\EmailVerificationCode;
use App\Services\Whatsapp;
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
        if($user->email) {
            $user->notify(new EmailVerificationCode());
        } else {
            if($user->role == 'سائق') {
                Whatsapp::send_code($user->driver->number);
            } elseif($user->role == 'معلن') {
                Whatsapp::send_code($user->stackholder->number);
            } else {
                Whatsapp::send_code($user->number);
            }
        }
        return 'The code has been sent successfully.';
    }
}
