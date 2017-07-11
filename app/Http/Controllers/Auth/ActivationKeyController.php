<?php

namespace App\Http\Controllers\Auth;

use App\ActivationKey;
use App\Traits\ActivationKeyTrait;
use App\Traits\reCaptchaTrait;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ActivationKeyController extends Controller
{
    use ActivationKeyTrait;
    use reCaptchaTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data['captcha-verified'] = $this->verifyCaptcha($data['g-recaptcha-response']);

        $validator = Validator::make($data,
            [
                'email' => 'required|email',
                'g-recaptcha-response'  => 'required',
                'captcha-verified'      => 'required|min:1'
            ],
            [
                'g-recaptcha-response.required' => trans('validation.grrequired'),
                'captcha-verified.min'           => trans('validation.grmin')
            ]);

        return $validator;

    }

    public function showKeyResendForm(){
        return view('auth.passwords.resend_key');
    }

    public function activateKey($activation_key)
    {
        // determine if the user is logged-in already
        if (Auth::check()) {
            if (auth()->user()->activated) {

                return redirect('/'.config('app.locale').'/'.trans('routes.home'))
                    ->with('message', trans('messages.activated.already'))
                    ->with('status', 'success');
            }

        }

        // get the activation key and chck if its valid
        $activationKey = ActivationKey::where('activation_key', $activation_key)
            ->first();

        if (empty($activationKey)) {

            return redirect()->route('login')
                ->with('message', trans('messages.activated.expire'))
                ->with('status', 'warning');

        }

        // process the activation key we're received
        $this->processActivationKey($activationKey);

        // redirect to the login page after a successful activation
        return redirect()->route('login')
            ->with('message', trans('messages.activated.success'))
            ->with('status', 'success');


    }

    public function resendKey(Request $request)
    {

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $email      = $request->get('email');

        // get the user associated to this activation key
        $user = User::where('email', $email)
            ->first();

        if (empty($user)) {
            return redirect()->route('activation_key_resend')
                ->with('message', trans('messages.activated.missing'))
                ->with('status', 'warning');
        }

        if ($user->activated) {
            return redirect()->route('login')
                ->with('message', trans('messages.activated.already'))
                ->with('status', 'success');
        }

        // queue up another activation email for the user
        $this->queueActivationKeyNotification($user,config('app.locale'));

        return redirect('/'.config('app.locale').'/')
            ->with('message', trans('messages.activated.resend'))
            ->with('status', 'success');
    }
}
