<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomPasswordResetNotification extends Notification
{
    use Queueable;

    /**
     * Password reset token.
     */
    protected string $token;


    /**
     * Create notification.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }


    /**
     * Notification channels.
     */
    public function via(object $notifiable): array
    {
        return [
            'mail',
        ];
    }


    /**
     * Email notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $resetUrl = url(
            route(
                'password.reset',
                [
                    'token' => $this->token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ],
                false
            )
        );

        return (new MailMessage)
            ->subject('Password Reset Requested - TaskForge')
            ->view(
                'emails.password-reset',
                [
                    'user' => $notifiable,
                    'resetUrl' => $resetUrl,
                ]
            );
    }
}