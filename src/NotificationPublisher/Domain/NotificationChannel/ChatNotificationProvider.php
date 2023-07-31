<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Domain\NotificationChannel;

use App\NotificationPublisher\Application\Service\NotificationProviderInterface;
use Symfony\Component\Notifier\ChatterInterface;

abstract class ChatNotificationProvider implements NotificationProviderInterface
{
    protected ChatterInterface $chatter;

    public function __construct(ChatterInterface $chatter)
    {
        $this->chatter = $chatter;
    }
}
