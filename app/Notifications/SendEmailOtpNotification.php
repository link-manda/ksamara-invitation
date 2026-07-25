<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmailOtpNotification extends Notification
{
    use Queueable;

    public function __construct(public string $otpCode) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Kode OTP Verifikasi: '.$this->otpCode.' - Samara Invitation')
            ->view('emails.otp', [
                'name' => $notifiable->name,
                'otpCode' => $this->otpCode,
            ]);
    }
}
