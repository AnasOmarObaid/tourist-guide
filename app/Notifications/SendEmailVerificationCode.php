<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmailVerificationCode extends Notification
{
    use Queueable;

    protected int $code;
    protected string $full_name;
    /**
     * Create a new notification instance.
     */
    public function __construct(int $code, string $full_name)
    {
        $this->code = $code;
        $this->full_name = $full_name;
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
        return (new MailMessage)->markdown(
            'mail.verification-code',
            [
                'code' => $this->code,
                'full_name' => $this->full_name
            ]
        );
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
