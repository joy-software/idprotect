<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 30/06/2017
 * Time: 04:27
 */

namespace App\Traits;


use App\User;
use App\ActivationKey;
use Illuminate\Support\Facades\Validator;
use App\Notifications\ActivationKeyCreatedNotification;



trait ActivationKeyTrait
{

    public function queueActivationKeyNotification(User $user,$lang)
    {
        // check if we need to send an activation email to the user. If not, we simply break
        if ( (env('settings.send_activation_email') == false)  || ($this->validateEmail($user) == false)) {
            return true;

        }

        $this->createActivationKeyAndNotify($user,$lang);

    }

    protected function validateEmail(User $user)
    {

        // Check that the user poses a valid email
        $validator = Validator::make(['email' => $user->email], ['email' => 'required|email']);

        if ($validator->fails()) {
            return false; // could not get a valid email
        }

        return true;

    }

    public function createActivationKeyAndNotify(User $user,$lang)
    {
        //if user is already activated, then there is nothing to do
        if ($user->activated) {
            return redirect('/')
                ->with('message', trans('messages.register.already_activated'))
                ->with('status', 'success');
        }

        // check to see if we already have an activation key for this user. If so, use it. If not, create one
        $activationKey = activationKey::where('user_id', $user->id)->first();
        if(empty($activationKey)){
            // Create new Activation key for this user/email
            $activationKey = new ActivationKey;
            $activationKey->user_id = $user->id;
            $activationKey->activation_key = str_random(64);
            $activationKey->save();
        }

        //send Activation Key notification

        $user->notify(new ActivationKeyCreatedNotification($activationKey,$lang));


    }

    public function processActivationKey(ActivationKey $activationKey){
        // get the user associated to this activation key
        $userToActivate = User::where('id', $activationKey->user_id)
            ->first();

        if (empty($userToActivate)) {
            return redirect('/')
                ->with('message', trans('messages.register.not_found_activationKey'))
                ->with('status', 'success');
        }

        // set the user to activated
        $userToActivate->activated = true;
        $userToActivate->save();

        // delete the activation key
        $activationKey->delete();
    }
}