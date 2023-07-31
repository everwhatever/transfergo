<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Application\Command;

readonly class NotificationMessage
{
    public string $recipient;

    public string $message;

    public function __construct(string $recipient, string $message)
    {
        $this->recipient = $recipient;
        $this->message = $message;
    }
}

