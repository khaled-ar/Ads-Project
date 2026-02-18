<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\{
    ForgotPasswordRequest,
    ResendCodeRequest
};
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\DatabaseNotification;
use App\Notifications\FcmNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EmailController extends Controller
{
    public function verify(Request $request) {
        $request->validate([
            'username' => ['required', 'string', 'exists:users,username']
        ]);

        $user = User::whereUsername($request->username)->first() ?? null;
        $user_data = Cache::get($user->email ?? $user->driver->number) ?? null;

        if(! $user_data) {
            return $this->generalResponse(null, 'Please Request the Code again', 400);
        }
        if($request->code != $user_data) {
            return $this->generalResponse(null, 'Please Ckeck the Code', 400);
        }
        $user->update([
            'email_verified_at' => now()
        ]);
        $notifiables = User::whereRole('ادمن')->get();
        $subject = "لقد تم انشاء حساب سائق جديد، يرجى الاطلاع";
        $body = [
            'driver_name' => $user->username,
            'driver_number' => $user->driver->number,
        ];
        foreach($notifiables as $notifiable) {
            $notifiable->notify(new FcmNotification($subject, "يريد {$user->username} الانضمام الى النظام"));
            $notifiable->notify(new DatabaseNotification($body, $subject, 'new_driver'));
        }
        Cache::forget($user->email ?? $user->driver->number);
        return $this->generalResponse(null, 'Account Verified Successfully');
    }

    public function forgot_password(ResendCodeRequest $request) {
        return $this->generalResponse(null, $request->resend());
    }

    public function resend_code(ResendCodeRequest $request) {
        return $this->generalResponse(null, $request->resend());
    }
}
