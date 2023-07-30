<?php

namespace App\Tests\NotificationPublisher\Domain\NotificationChannel;

use App\NotificationPublisher\Domain\NotificationChannel\EmailNotificationProvider;
use PHPUnit\Framework\TestCase;

class EmailNotificationProviderTest extends TestCase
{
    public function testSendNotification()
    {
        // Replace the following variables with actual email recipient and message
        $recipient = 'user@example.com';
        $message = 'Hello, this is a test email notification!';

        $provider = new EmailNotificationProvider();
        $result = $provider->send($recipient, $message);

        // Assuming a successful email sending, the result should be true
        $this->assertTrue($result);
    }
}
