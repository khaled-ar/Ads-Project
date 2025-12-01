<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class EmailVerificationCode extends Notification
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
    public function toMail(object $notifiable): MailMessage
    {
        $code = substr(str_shuffle('0123456789'), 0, 6);
        Cache::put($notifiable->email, $code, 60 * 5);

        if(config('app.locale') == 'ar') {
            return (new MailMessage)
                ->subject('تأكيد الحساب')
                ->greeting("مرحبًا {$notifiable->username}،")
                ->line('لقد تم إرسال هذا البريد إليك لتأكيد حسابك، يرجى تأكيد بريدك الإلكتروني باستخدام الكود أدناه.')
                ->line("كود التأكيد الخاص بك صالح لمدة خمسة دقائق فقط")
              	->line($code)
                ->line('شكرًا لاستخدامك تطبيقنا!');
        }

        return (new MailMessage)
                    ->subject('Account Verification')
                    ->greeting("Hello {$notifiable->username},")
                    ->line('This mail was sent to you for account verification, so please verify your email using the code below.')
                    ->line("Your Verification Code: {$code} (Valid for 5 minutes only).")
                    ->line('Thank you for using our application!');
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
