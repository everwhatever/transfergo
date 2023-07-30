<?php

// tests/Controller/NotificationControllerTest.php
declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twilio\Rest\Client;

class NotificationControllerTest extends WebTestCase
{
    public function testSendNotification(): void
    {
        $twilioAccountSid = 'your_twilio_account_sid';
        $twilioAuthToken = 'your_twilio_auth_token';
        $twilioFromNumber = 'your_twilio_phone_number';

        $twilioClient = new Client($twilioAccountSid, $twilioAuthToken);

        $client = static::createClient();
        $data = [
            'recipient' => 'recipient@example.com',
            'message' => 'This is a test notification.',
            'subject' => 'Test Notification',
        ];
        $client->request(Request::METHOD_POST, '/send-notification', [], [], [], json_encode($data));

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $container = $client->getContainer();
        $messageBus = $container->get('messenger.default_bus');
        $this->assertCount(1, $messageBus->getDispatchedMessages());

        $this->assertTrue($twilioClient->getLastRequest()->hasHeader('Authorization'));
        $this->assertStringContainsString($twilioFromNumber, $twilioClient->getLastRequest()->getUri()->getQuery());

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('Notification sent successfully.', $responseData['message']);
    }
}

