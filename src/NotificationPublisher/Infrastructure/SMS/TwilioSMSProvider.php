<?php

declare(strict_types=1);

namespace App\NotificationPublisher\Infrastructure\SMS;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;
use App\NotificationPublisher\Domain\NotificationChannel\SMSNotificationProvider;

class TwilioSMSProvider extends SMSNotificationProvider
{
    private string $twilioAccountSid;
    private string $twilioAuthToken;
    private string $twilioFromNumber;

    public function __construct(string $twilioAccountSid, string $twilioAuthToken, string $twilioFromNumber)
    {
        $this->twilioAccountSid = $twilioAccountSid;
        $this->twilioAuthToken = $twilioAuthToken;
        $this->twilioFromNumber = $twilioFromNumber;
    }

    /**
     * @throws ConfigurationException
     */
    public function sendSMS(string $recipient, string $message): bool
    {
        $twilioClient = new Client($this->twilioAccountSid, $this->twilioAuthToken);

        try {
            $twilioClient->messages->create(
                $recipient,
                [
                    'from' => $this->twilioFromNumber,
                    'body' => $message,
                ]
            );

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
