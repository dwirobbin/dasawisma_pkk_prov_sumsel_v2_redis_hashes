<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginViaToken extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public string $link)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Login Tanpa Password')
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->greeting('Hallo!')
            ->line('Silahkan klik tombol dibawah ini untuk masuk ke website ' . config('app.name') . ' tanpa password.')
            ->action('Go to home ', url($this->link))
            ->line('Jika anda merasa tidak meminta tindakan ini, Abaikan pesan ini.')
            ->salutation('Salam')
            ->salutation(config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
