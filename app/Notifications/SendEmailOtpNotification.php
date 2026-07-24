<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

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
            ->subject('🔐 Kode OTP Verifikasi: '.$this->otpCode.' - Samara Invitation')
            ->greeting('Halo, '.$notifiable->name.'!')
            ->line('Terima kasih telah mendaftar di **Samara Invitation**.')
            ->line('Gunakan 6-digit kode OTP di bawah ini untuk mengonfirmasi verifikasi alamat email Anda:')
            ->line(new HtmlString('
                <div style="text-align: center; margin: 24px 0;">
                    <div style="display: inline-block; background: #fef3c7; border: 2px dashed #f59e0b; padding: 16px 28px; border-radius: 16px; font-family: monospace, Courier, monospace; font-size: 30px; font-weight: 800; letter-spacing: 6px; color: #b45309;">
                        '.$this->otpCode.'
                    </div>
                </div>
            '))
            ->line('⚠️ **Catatan Keamanan:** Kode OTP ini hanya berlaku selama **10 menit**. Mohon jaga kerahasiaan kode ini dan jangan berikan kepada pihak mana pun.')
            ->line('Jika Anda tidak merasa mendaftar di Samara Invitation, abaikan email ini.')
            ->salutation(new HtmlString('Salam hangat,<br><strong>Tim Samara Invitation</strong>'));
    }
}
