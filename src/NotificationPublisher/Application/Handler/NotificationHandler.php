<?php

namespace App\NotificationPublisher\Application\Handler;

use App\NotificationPublisher\Application\Command\NotificationMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\NotificationPublisher\Application\Service\NotificationChannel;

class NotificationHandler implements MessageHandlerInterface
{
    private NotificationChannel $notificationChannel;

    public function __construct(NotificationChannel $notificationChannel)
    {
        $this->notificationChannel = $notificationChannel;
    }

    public function __invoke(NotificationMessage $message)
    {
        $recipient = $message->recipient;
        $subject = $message->subject;
        $messageText = $message->message;

//        $channels = ['email', 'sms'];
//
//        if (in_array('email', $channels)) {
//            $awsAccessKeyId = 'your_aws_access_key_id';
//            $awsSecretAccessKey = 'your_aws_secret_access_key';
//            $awsRegion = 'your_aws_region';
//            $senderEmail = 'your_sender_email@example.com';
//
//            $emailProvider = new AWSEmailProvider($awsAccessKeyId, $awsSecretAccessKey, $awsRegion, $senderEmail);
//            $this->notificationChannel->addProvider($emailProvider);
//        }
//
//        if (in_array('sms', $channels)) {
//            // Replace the following variables with your Twilio test credentials
//            $twilioAccountSid = 'your_twilio_account_sid';
//            $twilioAuthToken = 'your_twilio_auth_token';
//            $twilioFromNumber = 'your_twilio_phone_number';
//
//            $smsProvider = new TwilioSMSProvider($twilioAccountSid, $twilioAuthToken, $twilioFromNumber);
//            $this->notificationChannel->addProvider($smsProvider);
//        }

        $this->notificationChannel->sendNotification($recipient, $messageText, $subject);
    }
}
