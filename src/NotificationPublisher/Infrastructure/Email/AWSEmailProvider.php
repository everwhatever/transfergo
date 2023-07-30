<?php

namespace App\NotificationPublisher\Infrastructure\Email;

use App\NotificationPublisher\Domain\NotificationChannel\EmailNotificationProvider;
use Aws\Ses\SesClient;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

class AWSEmailProvider extends EmailNotificationProvider
{
    private string $awsAccessKeyId;
    private string $awsSecretAccessKey;
    private string $awsRegion;
    private string $senderEmail;

    public function __construct(string $awsAccessKeyId, string $awsSecretAccessKey, string $awsRegion, string $senderEmail)
    {
        $this->awsAccessKeyId = $awsAccessKeyId;
        $this->awsSecretAccessKey = $awsSecretAccessKey;
        $this->awsRegion = $awsRegion;
        $this->senderEmail = $senderEmail;
    }

    public function sendEmail(string $recipient, string $message, string $subject): bool
    {
        $sesClient = new SesClient([
            'version' => 'latest',
            'region' => $this->awsRegion,
            'credentials' => [
                'key' => $this->awsAccessKeyId,
                'secret' => $this->awsSecretAccessKey,
            ],
        ]);

        try {
            $sesClient->sendEmail([
                'Source' => $this->senderEmail,
                'Destination' => [
                    'ToAddresses' => [$recipient],
                ],
                'Message' => [
                    'Subject' => [
                        'Data' => $subject,
                        'Charset' => 'UTF-8',
                    ],
                    'Body' => [
                        'Text' => [
                            'Data' => $message,
                            'Charset' => 'UTF-8',
                        ],
                    ],
                ],
            ]);

            return true;
        } catch (\Exception $e) {
            $logger = new Logger('aws_email');
            $logger->pushHandler(new StreamHandler('src/file.log', Level::Error));
            $logger->error('AWS Email API Error: ' . $e->getMessage(), ['exception' => $e]);

            return false;
        }
    }
}
