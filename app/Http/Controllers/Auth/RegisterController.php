<?php

namespace App\Http\Controllers\Auth;

use App\Traits\ActivationKeyTrait;
use App\Traits\reCaptchaTrait;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use ActivationKeyTrait;
    use reCaptchaTrait;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'en/home';

    /**
     *  Create a new controller instance.
     * RegisterController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->redirectTo = '/'.config('app.locale');
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

        return Validator::make($data, [
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|same:password',
            'g-recaptcha-response'  => 'required',
            'captcha-verified'      => 'required|min:1'
        ],
        [
            'g-recaptcha-response.required' => trans('validation.grrequired'),
            'captcha-verified.min'           => trans('validation.grmin')
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'activated' => !env('settings.send_activation_email')
        ]);
    }


    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        // create the user
        $user = $this->create($request->all());

        // process the activation email for the user
        $this->queueActivationKeyNotification($user,config('app.locale'));

        // we do not want to login the new user
        return redirect()->route('login')
            ->with('message', trans('messages.register.success'))
            ->with('status', 'success');
    }
}
