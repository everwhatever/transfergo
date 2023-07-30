<?php

namespace App\NotificationPublisher\Domain\NotificationChannel;

use App\NotificationPublisher\Application\Service\NotificationProviderInterface;

abstract class SMSNotificationProvider implements NotificationProviderInterface
{
    public function send(string $recipient, string $message, string $subject = ''): bool
    {
        $result = $this->sendSMS($recipient, $message);

        // You can add additional common logic here if needed

        return $result;
    }

    // This method must be implemented by specific providers like TwilioSMSProvider
    abstract public function sendSMS(string $recipient, string $message): bool;
}
