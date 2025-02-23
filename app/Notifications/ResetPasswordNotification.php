<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    private $token;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
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
            ->subject('Redefinição de Senha')
            ->greeting('Olá ' . $notifiable->name . ',')
            ->line('Você solicitou a redefinição de sua senha. Clique no botão abaixo para prosseguir:')
            ->action('Redefinir Senha', route('recover-password.view', ['token' => $this->token, 'email' => $notifiable->email]))
            ->line('Se você não solicitou essa alteração, ignore este e-mail.')
            ->salutation('Atenciosamente');
    }
}
