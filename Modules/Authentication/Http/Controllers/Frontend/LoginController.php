<?php

namespace Modules\Authentication\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\MessageBag;
use Modules\Authentication\Foundation\{Authentication,MobileAuthentication};
use Modules\Authentication\Http\Requests\Frontend\{LoginRequest,verificationOtpRequest};
use Modules\Authentication\Notifications\Frontend\WelcomeNotification;
use Modules\Cart\Traits\CartTrait;
use MongoDB\Driver\Session;

class LoginController extends Controller
{
    use Authentication,MobileAuthentication,CartTrait;

    /**
     * Display a listing of the resource.
     */
    public function showLogin(Request $request)
    {
        return view('authentication::frontend.login');
    }

    public function showVerificationOtp($mobile)
    {
        return view('authentication::frontend.verify-otp',compact('mobile'));
    }

    /**
     * Login method
     */
    public function postLogin(LoginRequest $request)
    {
        $redirectRoute = $this->loginOrRegister($request->email);
        if(session()->has('to_checkout') && session()->get('to_checkout') == 1){
            $redirectRoute = 'frontend.cart.index';
            $this->updateCartKey(session()->get('old_token'),auth()->id());
            session()->forget(['to_checkout','old_token']);
        }
        return redirect()->route($redirectRoute);
    }

    /**
     * Login method
     */
    public function verificationOtp(verificationOtpRequest $request)
    {
        $isVerified = $this->otpCheck($request->mobile,$request->otp);

        if(!$isVerified){

            $errors = new MessageBag([
                'otp' => [__("Invalid OTP")],
            ]);

            return redirect()->back()->with(["errors" => $errors]);
        }

        $redirectRoute = $this->loginOrRegister($request->mobile);
        if(session()->has('to_checkout') && session()->get('to_checkout') == 1){
            $redirectRoute = 'frontend.cart.index';
            $this->updateCartKey(session()->get('old_token'),auth()->id());
            session()->forget(['to_checkout','old_token']);
        }
        return redirect()->route($redirectRoute);
    }


    /**
     * Logout method
     */
    public function logout(Request $request)
    {
        auth()->logout();
        return redirect()->route('frontend.home');
    }
}
