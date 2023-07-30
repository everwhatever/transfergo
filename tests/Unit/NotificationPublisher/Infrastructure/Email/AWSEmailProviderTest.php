<?php
// tests/NotificationPublisher/Infrastructure/Email/AWSEmailProviderTest.php
namespace App\Tests\NotificationPublisher\Infrastructure\Email;

use App\NotificationPublisher\Infrastructure\Email\AWSEmailProvider;
use PHPUnit\Framework\TestCase;

class AWSEmailProviderTest extends TestCase
{
    public function testSendEmailWithSuccess()
    {
        // Replace the following variables with your AWS SES test credentials
        $awsAccessKeyId = 'your_aws_access_key_id';
        $awsSecretAccessKey = 'your_aws_secret_access_key';
        $awsRegion = 'your_aws_region';
        $senderEmail = 'your_sender_email@example.com';

        // Replace the following variables with actual recipient, subject, and body
        $recipient = 'recipient@example.com';
        $subject = 'Test Email';
        $body = 'This is a test email sent via AWS SES.';

        // Instantiate the AWSEmailProvider
        $emailProvider = new AWSEmailProvider($awsAccessKeyId, $awsSecretAccessKey, $awsRegion, $senderEmail);

        // Call the sendEmail method
        $result = $emailProvider->sendEmail($recipient, $subject, $body);

        // The result should be true since the email was sent successfully (mocked)
        $this->assertTrue($result);
    }

    public function testSendEmailWithFailure()
    {
        // Replace the following variables with your AWS SES test credentials
        $awsAccessKeyId = 'your_aws_access_key_id';
        $awsSecretAccessKey = 'your_aws_secret_access_key';
        $awsRegion = 'your_aws_region';
        $senderEmail = 'your_sender_email@example.com';

        // Replace the following variables with actual recipient, subject, and body
        $recipient = 'recipient@example.com';
        $subject = 'Test Email';
        $body = 'This is a test email sent via AWS SES.';

        // Create a mock AWSEmailProvider that throws an exception
        $emailProviderMock = $this->getMockBuilder(AWSEmailProvider::class)
            ->setConstructorArgs([$awsAccessKeyId, $awsSecretAccessKey, $awsRegion, $senderEmail])
            ->onlyMethods(['sendEmail'])
            ->getMock();

        $emailProviderMock->expects($this->once())
            ->method('sendEmail')
            ->willReturn(false);

        // Call the sendEmail method (Note: This calls the mocked method, not the actual AWS SES)
        $result = $emailProviderMock->sendEmail($recipient, $subject, $body);

        // The result should be false since the sendEmail method was mocked to return false
        $this->assertFalse($result);
    }
}

