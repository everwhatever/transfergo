<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Application\Command;

readonly class NotificationMessage
{
    public string $recipient;
    public string $message;
    public string $subject;

    public function __construct(string $recipient, string $message, string $subject = '')
    {
        $this->recipient = $recipient;
        $this->message = $message;
        $this->subject = $subject;
    }
}

