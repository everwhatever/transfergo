<?php

namespace App\Tests\NotificationPublisher\Domain\NotificationChannel;

use App\NotificationPublisher\Domain\NotificationChannel\SMSNotificationProvider;
use PHPUnit\Framework\TestCase;

class SMSNotificationProviderTest extends TestCase
{
    public function testSendNotification()
    {
        // Replace the following variables with actual phone number and message
        $recipient = '+1234567890';
        $message = 'Hello, this is a test SMS notification!';

        $provider = new SMSNotificationProvider();
        $result = $provider->send($recipient, $message);

        // Assuming a successful SMS sending, the result should be true
        $this->assertTrue($result);
    }
}
