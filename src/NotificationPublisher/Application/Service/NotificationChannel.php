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

    public function sendNotification(string $recipient, string $message, string $subject = ''): bool
    {
        $isSent = $this->sendNotificationByProviders($recipient, $message, $subject);

        if (!$isSent) {
            sleep(60);
            return $this->sendNotificationByProviders($recipient, $message, $subject);
        }

        return true;
    }

    private function sendNotificationByProviders(string $recipient, string $message, string $subject): bool
    {
        foreach ($this->providers as $provider) {
            if ($provider instanceof NotificationProviderInterface) {
                if ($provider->send($recipient, $message, $subject)) {
                    return true;
                }
            }
        }

        return false;
    }
}
