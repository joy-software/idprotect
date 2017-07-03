<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ActivationKeyCreatedNotification extends Notification
{
    use Queueable;

    protected $activationKey;
    protected $lang;

    /**
     * Create a new notification instance.
     * ActivationKeyCreatedNotification constructor.
     * @param $activationKey
     * @param $lang
     */
    public function __construct($activationKey,$lang)
    {
        $this->activationKey = $activationKey;
        $this->$lang = $lang;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(trans('messages.activationMail.subject',[],$this->lang))
            ->greeting('Hello, '.$notifiable->username)
            ->line(trans('messages.activationMail.line1',[],$this->lang))
            ->line(trans('messages.activationMail.line2',[],$this->lang))
            ->action(trans('messages.activationMail.action',[],$this->lang), route('activation_key', ['activation_key' => $this->activationKey->activation_key, 'email' => $notifiable->email]))
            ->line(trans('messages.activationMail.line3',[],$this->lang).'.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
