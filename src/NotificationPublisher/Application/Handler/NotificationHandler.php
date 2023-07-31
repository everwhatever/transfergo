<?php

namespace App\NotificationPublisher\Application\Handler;

use App\NotificationPublisher\Application\Command\NotificationMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\NotificationPublisher\Application\Service\NotificationChannel;

class NotificationHandler implements MessageHandlerInterface
{
    private NotificationChannel $notificationChannel;

    public function __construct(NotificationChannel $notificationChannel)
    {
        $this->notificationChannel = $notificationChannel;
    }

    public function __invoke(NotificationMessage $message): void
    {
        $recipient = $message->recipient;
        $subject = $message->subject;
        $messageText = $message->message;

        $this->notificationChannel->sendNotification($recipient, $messageText, $subject);
    }
}
