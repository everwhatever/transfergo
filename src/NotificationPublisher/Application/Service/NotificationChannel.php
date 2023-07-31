<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Application\Service;

class NotificationChannel implements NotificationChannelInterface
{
    private array $providers;

    public function __construct(array $providerNames, NotificationProviderFactory $providerFactory)
    {
        $this->providers = $providerFactory->createProviders($providerNames);
    }

    public function sendNotification(string $recipient, string $message, string $subject = ''): void
    {
        foreach ($this->providers as $provider) {
            if (!$provider instanceof NotificationProviderInterface) {
                continue;
            }

            if ($provider->send($recipient, $message, $subject)) {
                return;
            }
        }
    }
}
