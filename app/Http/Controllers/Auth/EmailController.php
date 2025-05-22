<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\{
    ForgotPasswordRequest,
    ResendCodeRequest
};
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EmailController extends Controller
{
    public function verify(Request $request) {
        $user_data = Cache::get($request->ip()) ?? null;
        if(! $user_data) {
            return $this->generalResponse(null, 'Please Request the Code again', 400);
        }
        if($request->code != $user_data[1]) {
            return $this->generalResponse(null, 'Please Ckeck the Code', 400);
        }
        User::whereEmail($user_data[0])->update([
            'email_verified_at' => now()
        ]);
        Cache::forget($request->ip());
        return $this->generalResponse(null, 'Email Verified Successfully');
    }

    public function forgot_password(ForgotPasswordRequest $request) {
        $request->send_email();
        return $this->generalResponse(null, 'Verification Code was Sent Successfully to your email');
    }

    public function resend_code(ResendCodeRequest $request) {
        return $this->generalResponse(null, $request->resend());
    }
}
