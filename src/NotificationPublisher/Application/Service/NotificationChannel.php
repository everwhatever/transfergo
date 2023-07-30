<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Application\Service;

class NotificationChannel implements NotificationChannelInterface
{
    private array $providers = [];

    public function __construct(array $providers)
    {
        $this->providers = $providers;
    }

    public function sendNotification(string $recipient, string $message): bool
    {
        foreach ($this->providers as $provider) {
            if ($provider instanceof NotificationProviderInterface) {
                if ($provider->send($recipient, $message)) {
                    return true;
                }
            }
        }

        return false;
    }
}
