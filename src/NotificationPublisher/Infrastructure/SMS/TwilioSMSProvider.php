<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Infrastructure\SMS;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\TexterInterface;
use App\NotificationPublisher\Domain\NotificationChannel\SMSNotificationProvider;

class TwilioSMSProvider extends SMSNotificationProvider
{
    private TexterInterface $texter;

    public function __construct(TexterInterface $texter)
    {
        $this->texter = $texter;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendSMS(string $recipient, string $message): bool
    {
        try {

            $sms = new SmsMessage(
                $recipient,
                $message,
            );

            $this->texter->send($sms);

            return true;
        } catch (\Exception $e) {
            // Log the error using Monolog
            $logger = new Logger('twilio_sms');
            $logger->pushHandler(new StreamHandler('src/file.log', Level::Error));
            $logger->error('Twilio API Error: ' . $e->getMessage(), ['exception' => $e]);

            return false;
        }
    }
}
