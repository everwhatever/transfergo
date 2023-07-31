<?php

namespace App\NotificationPublisher\Domain\NotificationChannel;

use App\NotificationPublisher\Application\Service\NotificationProviderInterface;
use Symfony\Component\Notifier\TexterInterface;

abstract class SMSNotificationProvider implements NotificationProviderInterface
{
    protected TexterInterface $texter;

    public function __construct(TexterInterface $texter)
    {
        $this->texter = $texter;
    }
}
