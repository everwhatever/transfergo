<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Infrastructure\SMS;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;
use Symfony\Component\Notifier\Message\SmsMessage;
use App\NotificationPublisher\Domain\NotificationChannel\SMSNotificationProvider;

class TwilioSMSProvider extends SMSNotificationProvider
{
    /**
     * @throws TransportExceptionInterface
     */
    public function send(string $recipient, string $message): bool
    {
        try {
            $sms = new SmsMessage(
                $recipient,
                $message,
            );

            $this->texter->send($sms);

            return true;
        } catch (\Exception $e) {
            $logger = new Logger('twilio_sms');
            $logger->pushHandler(new StreamHandler('src/file.log', Level::Error));
            $logger->error('Twilio API Error: ' . $e->getMessage(), ['exception' => $e]);

            return false;
        }
    }
}
