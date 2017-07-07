<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 28/06/2017
 * Time: 21:12
 */

namespace App\Traits;
use App\SocialAccount;
use App\User;
use Laravel\Socialite\Contracts\User as ProviderUser;


trait SocialAccountTrait
{
    /**
     * @param ProviderUser $providerUser
     * @param $provider
     * @return mixed
     */
    public function createOrGetUser(ProviderUser $providerUser,$provider)
    {
        $account = SocialAccount::whereProvider($provider)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {

            $account = new SocialAccount([
                'email' => $providerUser->getEmail(),
                'provider_user_id' => $providerUser->getId(),
                'provider' => $provider
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {

                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'nickname' => $providerUser->getNickname(),
                    'avatar' => $providerUser->getAvatar(),
                    'activated' => 1
                ]);
            }
            else
            {
                if(!$user->nickname)
                {
                    $user->nickname = $providerUser->getNickname();
                }
                if(!$user->avatar)
                {
                    $user->avatar = $providerUser->getAvatar();
                }

            }

            $account->user()->associate($user);
            $account->save();

            return $user;

        }

    }
}