<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\reCaptchaTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    use reCaptchaTrait;

    /**
     * Create a new controller instance.
     * ForgotPasswordController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->redirectTo = '/'.config('app.locale').'/'.trans('routes.home');
    }

    /**
     * Validate the email for the given request.
     *
     * @param \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {

        //recaptcha pre-validation
        $request['captcha-verified'] = $this->verifyCaptcha($request->input('g-recaptcha-response'));

        $this->validate($request,
            [
                'email' => 'required|email',
                'g-recaptcha-response'  => 'required',
                'captcha-verified'      => 'required|min:1'
            ],
            [
                'g-recaptcha-response.required' => trans('validation.grrequired'),
                'captcha-verified.min'           => trans('validation.grmin')
            ]);
    }
}
