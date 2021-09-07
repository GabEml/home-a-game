<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Sessiongame extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $sessiongames, $mailAdmin, $user)
    {
        $this->sessiongames=$sessiongames;
        $this->mailAdmin=$mailAdmin;
        $this->user=$user;
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
        ->subject('Vous êtes inscrit à des sessions !')
        ->cc($this->mailAdmin)
        ->line('Bonjour !')
        ->line('Félicitations '. $this->user . ', vous êtes inscrit à :')
        ->line($this->sessiongames)
        ->line('Allez vite participer à la session en cours pour gagner !')
        ->line('Cordialement,');
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
