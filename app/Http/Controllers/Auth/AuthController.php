<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\{
    LoginRequest,
    RegisterRequest,
    ResetPasswordRequest,
};

use App\Http\Requests\Drivers\UpdateProfileRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {

        if(! $request->authenticate()) {
            return $this->generalResponse(null, 'Wrong data!', 401);
        }

        return $this->generalResponse($request->getData(), 'Welcome Back!', 200);
    }

    public function register(RegisterRequest $request) {
        return $this->generalResponse($request->store(), null, 201);
    }

    public function reset_password(ResetPasswordRequest $request) {
        return $request->update_password();
    }

    public function update_driver_profile(UpdateProfileRequest $request) {
        return $this->generalResponse(null, $request->update_profile());
    }

    public function logout(Request $request) {
        request()->user()->tokens()->delete();
        return $this->generalResponse(null, 'Logged Out Successfully.', 200);
    }
}
