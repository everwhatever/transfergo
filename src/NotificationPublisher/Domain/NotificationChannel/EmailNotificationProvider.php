<?php

namespace App\NotificationPublisher\Domain\NotificationChannel;

use App\NotificationPublisher\Application\Service\NotificationProviderInterface;

abstract class EmailNotificationProvider implements NotificationProviderInterface
{
    public function send(string $recipient, string $message, string $subject): bool
    {
        $result = $this->sendEmail($recipient, $message, $subject);

        // You can add additional common logic here if needed

        return $result;
    }
    abstract public function sendEmail(string $recipient, string $message, string $subject): bool;
}
