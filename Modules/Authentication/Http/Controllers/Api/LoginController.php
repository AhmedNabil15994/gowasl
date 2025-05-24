<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Authentication\Http\Requests\Frontend\verificationOtpRequest;
use Modules\Authentication\Repositories\Api\AuthenticationRepository;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Authentication\Foundation\{Authentication,MobileAuthentication};
use Modules\Authentication\Http\Requests\Api\LoginRequest;

class LoginController extends ApiController
{
    use Authentication,MobileAuthentication;

    private $auth;
    private $guard;

    public function __construct(AuthenticationRepository $auth)
    {
        $this->auth = $auth;
    }

    public function sendingOtp(LoginRequest $request)
    { 
        $otp = $this->sendOtp($request->mobile);
        return $this->response(['otp' => env("APP_ENV") != 'production' ? $otp->otp : null]);
    }

    public function postLogin(verificationOtpRequest $request)
    {
        $isVerified = $this->otpCheck($request->mobile,$request->otp);

        if(!$isVerified)
            return $this->error(__("Invalid OTP"));
        
        $user = $this->loginOrRegister($request->mobile);
        
        return $this->auth->tokenResponse($request, $user);
    }

    public function frontLogin($user){

    }

    public function loginReponse($user,$route){

        return $user;
    }

    public function logout(Request $request)
    {
        $fcmToken=$request->user()->fcmTokens()->where('firebase_token', $request->token)->first();

        if ($fcmToken) {
            $fcmToken->delete();
        }
        $request->user()->currentAccessToken()->delete();
        return $this->response([], __('authentication::api.logout.messages.success'));
    }
}
