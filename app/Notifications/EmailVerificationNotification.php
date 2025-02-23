<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerificationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
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
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Verifique seu e-mail')
            ->greeting('Olá ' . $notifiable->name . ',')
            ->line('Obrigado por se cadastrar em nosso site!')
            ->line('Clique no botão abaixo para verificar seu e-mail.')
            ->action('Verificar E-mail', route('validate-email', ['id' => $notifiable->id, 'token' => $notifiable->email_verification_token]))
            ->line('Se você não fez esse cadastro, ignore este e-mail.')
            ->salutation('Atenciosamente');
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
