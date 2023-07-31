<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Infrastructure\Chat;

use App\NotificationPublisher\Domain\NotificationChannel\ChatNotificationProvider;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Symfony\Component\Notifier\Message\ChatMessage;

class TelegramChatProvider extends ChatNotificationProvider
{
    public function send(string $recipient, string $message): bool
    {
        try {
            $message = (new ChatMessage($message));

            $this->chatter->send($message);

            return true;
        } catch (\Exception $e) {
            $logger = new Logger('telegram_chat');
            $logger->pushHandler(new StreamHandler('src/file.log', Level::Error));
            $logger->error('Telegram chat Error: ' . $e->getMessage(), ['exception' => $e]);

            return false;
        }
    }
}
