<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Application\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

class NotificationProviderFactory
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function createProviders(array $providerNames): array
    {
        $providers = [];
        foreach ($providerNames as $providerName) {
            if ($this->container->has($providerName)) {
                $providers[] = $this->container->get($providerName);
            }
        }

        return $providers;
    }
}
