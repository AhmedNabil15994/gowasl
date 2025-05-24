<?php

namespace Modules\Authentication\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Area\Entities\Country;
use Modules\Authentication\Http\Requests\Frontend\RegisterDuringOrderRequest;
use PragmaRX\Countries\Package\Countries;
use Modules\Authentication\Mail\WelcomeMail;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\Frontend\RegisterRequest;
use Modules\Authentication\Notifications\Frontend\WelcomeNotification;
use Modules\Authentication\Repositories\Frontend\AuthenticationRepository as AuthenticationRepo;
use Modules\Cart\Traits\CartTrait;

class RegisterController extends Controller
{
    use Authentication, CartTrait;

    protected $auth;

    public function __construct(AuthenticationRepo $auth)
    {
        $this->auth = $auth;
    }

    public function registerDuringOrder(RegisterRequest $request)
    {
        $registered = $this->auth->register($request->validated());
        if ($registered) {
            $this->loginAfterRegister($request);
            return  true;
        } else {
            return redirect()->back()->with(['errors' => 'try again']);
        }
    }

    public function show(Request $request)
    {
        return view('authentication::frontend.register', compact('request'));
    }

    public function register(RegisterRequest $request)
    {
        $registered = $this->auth->register($request->validated());
        if ($registered) {
            $this->loginAfterRegister($request);
//            auth()->user()->notify(new WelcomeNotification);
            return $this->redirectTo($request);
        } else {
            return redirect()->back()->with(['errors' => 'try again']);
        }
    }

    public function redirectTo($request)
    {
        return redirect()->route('frontend.home');
    }

    public function countries()
    {
        $countries = Country::pluck('title', 'id');

        return $countries;
    }

}
