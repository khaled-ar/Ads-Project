<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FcmChannel
{
    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        $message = $notification->toFcm($notifiable);
        Log::info('FCM notification runnig...: ');

        if (!$message) {
            Log::info('No message');
            return;
        }
        $token = $notifiable->routeNotificationForFcm($notification);
        if (empty($token)) {
            Log::info('No token');
            return;
        }

        try {
            $messaging = Firebase::messaging();
            // Send to single device
            $result = $messaging->send($message, $token);
            Log::info('FCM notification sent successfully: ' . $token);
            Log::info('With result: ' . $result);
        } catch (\Exception $e) {
            Log::error('FCM notification failed: ' . $e->getMessage());
        }
    }
}
