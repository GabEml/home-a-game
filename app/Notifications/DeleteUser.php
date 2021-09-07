<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeleteUser extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
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
        ->subject('Compte supprimé')
        ->cc('athomeagame@gmail.com')
        ->line('Bonjour '. $this->user . ',')
        ->line('Nous avons bien procédé à la suppression de vos données utilisateur sur la plateforme de jeu On The Road a Game At Home Edition.')
        ->line("Nous espérons que vous avez apprécié votre expérience avec nous et que ce départ n'est qu'un au revoir - pour mieux nous revenir dans un futur proche.")
        ->line('A bientôt, on the road...')
        ->line("L'équipe d'On The Road a Game")
        ;
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
