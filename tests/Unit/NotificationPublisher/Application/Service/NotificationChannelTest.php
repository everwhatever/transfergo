<?php

namespace App\Tests\NotificationPublisher\Application\Service;

use App\NotificationPublisher\Application\Service\NotificationChannel;
use App\NotificationPublisher\Domain\NotificationChannel\EmailNotificationProvider;
use PHPUnit\Framework\TestCase;

class NotificationChannelTest extends TestCase
{
    public function testSendNotificationWithSuccess()
    {
        $provider1 = $this->createMock(EmailNotificationProvider::class);
        $provider1->expects($this->once())
            ->method('send')
            ->willReturn(true);

        $provider2 = $this->createMock(EmailNotificationProvider::class);
        $provider2->expects($this->never())
            ->method('send');

        $providers = [$provider1, $provider2];

        $notificationChannel = new NotificationChannel($providers);

        $recipient = 'user@example.com';
        $message = 'Hello, this is a test notification!';

        $result = $notificationChannel->sendNotification($recipient, $message);

        // Assuming at least one provider succeeds, the result should be true
        $this->assertTrue($result);
    }

    public function testSendNotificationWithFailure()
    {
        // Mock SMSNotificationProvider
        $provider1 = $this->createMock(EmailNotificationProvider::class);
        $provider1->expects($this->once())
            ->method('send')
            ->willReturn(false);

        $provider2 = $this->createMock(EmailNotificationProvider::class);
        $provider2->expects($this->once())
            ->method('send')
            ->willReturn(false);

        $providers = [$provider1, $provider2];

        $notificationChannel = new NotificationChannel($providers);

        $recipient = 'user@example.com';
        $message = 'Hello, this is a test notification!';

        $result = $notificationChannel->sendNotification($recipient, $message);

        // If all providers fail, the result should be false
        $this->assertFalse($result);
    }
}
