<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmailChange extends Notification
{
    use Queueable;
    protected $emailChange;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($emailChange)
    {
        $this->emailChange = $emailChange;
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
        $url = url('/email/change/'.$this->emailChange->token);

        return (new MailMessage)
                    ->line('You are receiving this email because we received a change email request for your account.')
                    ->action('Change Email', url($url))
                    ->line('If you did not request a change email, no further action is required.');
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
