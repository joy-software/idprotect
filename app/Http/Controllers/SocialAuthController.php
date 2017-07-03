<?php

namespace App\Http\Controllers;

use App\Traits\SocialAccountTrait;
use Illuminate\Http\Request;
use Socialite;



class SocialAuthController extends Controller
{
    use SocialAccountTrait;

    /**
     * @param $provider
     * @return mixed
     */
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback($provider)
    {
        // when facebook call us a with token
        $providerUser = Socialite::driver($provider)->user();
        $user = $this->createOrGetUser($providerUser,$provider);

        auth()->login($user);

        return redirect()->to(env('SOCIAL_REDIRECT'));
    }
}
