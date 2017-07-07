<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Auth guard
     *
     * @var
     */
    protected $auth;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'en/home';

    /**
     * lockoutTime
     *
     * @var
     */
    protected $lockoutTime;

    /**
     * maxLoginAttempts
     *
     * @var
     */
    protected $maxLoginAttempts;

    /**
     * Create a new controller instance.
     * LoginController constructor.
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->auth = $auth;
        $this->lockoutTime  = 1;    //lockout for 1 minute (value is in minutes)
        $this->maxLoginAttempts = 2;    //lockout after 3 attempts
        $this->redirectTo = '/'.config('app.locale').'/'.trans('routes.home');
    }

    /**
     * Determine if the user has too many failed login attempts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), $this->maxLoginAttempts, $this->lockoutTime
        );
    }

    public function login(Request $request)
    {
        $email      = $request->get('email');
        $password   = $request->get('password');
        $remember   = $request->get('remember');

        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->auth->attempt([
            'email'     => $email,
            'password'  => $password,
            'activated'  => 1,
        ], $remember == 1 ? true : false)) {

            return redirect('/en/home');

        }
        else {
            $user = User::where('email','=',$email)->get()->first();

            if($user)
            {
                if(!$user['activated'])
                {
                    return redirect()->back()
                        ->with('message',trans('messages.loginController.notActivated').$user->email)
                        ->with('status', 'info')
                        ->withInput();
                }
            }
            $this->incrementLoginAttempts($request);
            return redirect()->back()
                ->with('message',trans('auth.failed'))
                ->with('status', 'danger')
                ->withInput();
        }

    }


    public function logout(Request $request)
    {
        $this->performLogout($request);
         return redirect('/'.config('app.locale').'/');
    }
}
