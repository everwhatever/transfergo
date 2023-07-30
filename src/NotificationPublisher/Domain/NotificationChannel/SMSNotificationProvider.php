<?php

namespace App\NotificationPublisher\Domain\NotificationChannel;

use App\NotificationPublisher\Application\Service\NotificationProviderInterface;

class SMSNotificationProvider implements NotificationProviderInterface
{
    public function send(string $recipient, string $message): bool
    {
        // TODO: Implement send() method.
    }
}
