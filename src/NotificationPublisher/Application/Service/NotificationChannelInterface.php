<?php

namespace App\NotificationPublisher\Application\Service;

interface NotificationChannelInterface
{
    public function sendNotification(string $recipient, string $message): bool;
}
