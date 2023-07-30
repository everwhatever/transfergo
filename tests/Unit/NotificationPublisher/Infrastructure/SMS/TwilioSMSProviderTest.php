<?php

namespace App\Tests\NotificationPublisher\Infrastructure\SMS;

use App\NotificationPublisher\Infrastructure\SMS\TwilioSMSProvider;
use Monolog\Handler\TestHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

class TwilioSMSProviderTest extends TestCase
{
    public function testSendSMSWithSuccess()
    {
        // Replace the following variables with your Twilio test credentials
        $twilioAccountSid = 'your_twilio_account_sid';
        $twilioAuthToken = 'your_twilio_auth_token';
        $twilioFromNumber = 'your_twilio_phone_number';

        // Replace the following variables with actual recipient and message
        $recipient = '+1234567890';
        $message = 'Hello, this is a test SMS message!';

        // Create a mock Twilio client that always succeeds (no actual API call)
        $twilioClientMock = $this->createMock(Client::class);
        $twilioClientMock->messages = $this->createMock(\stdClass::class);
        $twilioClientMock->messages->method('create')->willReturn(true);

        // Instantiate the TwilioSMSProvider with the mock Twilio client
        $smsProvider = new TwilioSMSProvider($twilioAccountSid, $twilioAuthToken, $twilioFromNumber);
        $smsProvider->setTwilioClient($twilioClientMock);

        // Call the sendSMS method
        $result = $smsProvider->sendSMS($recipient, $message);

        // The result should be true since we mocked a successful SMS send
        $this->assertTrue($result);
    }

    public function testSendSMSWithFailure()
    {
        // Replace the following variables with your Twilio test credentials
        $twilioAccountSid = 'your_twilio_account_sid';
        $twilioAuthToken = 'your_twilio_auth_token';
        $twilioFromNumber = 'your_twilio_phone_number';

        // Replace the following variables with actual recipient and message
        $recipient = '+1234567890';
        $message = 'Hello, this is a test SMS message!';

        // Create a mock Twilio client that throws a ConfigurationException
        $twilioClientMock = $this->createMock(Client::class);
        $twilioClientMock->method('messages')->willThrowException(new ConfigurationException('Twilio configuration error'));

        // Instantiate the TwilioSMSProvider with the mock Twilio client
        $smsProvider = new TwilioSMSProvider($twilioAccountSid, $twilioAuthToken, $twilioFromNumber);
        $smsProvider->setTwilioClient($twilioClientMock);

        // Create a test handler for Monolog to capture log messages
        $logger = new Logger('twilio_sms');
        $testHandler = new TestHandler();
        $logger->pushHandler($testHandler);

        // Call the sendSMS method
        $result = $smsProvider->sendSMS($recipient, $message);

        // The result should be false since we mocked a Twilio configuration error
        $this->assertFalse($result);

        // Verify that the error was logged
        $this->assertTrue($testHandler->hasErrorRecords());
    }
}
