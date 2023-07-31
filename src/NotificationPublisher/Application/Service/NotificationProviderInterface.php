<?php

namespace App\NotificationPublisher\Application\Service;

interface NotificationProviderInterface
{
    public function send(string $recipient, string $message): bool;
}
