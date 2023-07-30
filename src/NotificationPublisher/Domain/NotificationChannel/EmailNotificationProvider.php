<?php

namespace App\NotificationPublisher\Domain\NotificationChannel;

use App\NotificationPublisher\Application\Service\NotificationProviderInterface;

class EmailNotificationProvider implements NotificationProviderInterface
{
    public function send(string $recipient, string $message): bool
    {
        // TODO: Implement send() method.
    }
}
