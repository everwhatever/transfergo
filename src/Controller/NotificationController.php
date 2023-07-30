<?php

declare(strict_types=1);

namespace App\Controller;

use App\NotificationPublisher\Application\Command\NotificationMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    #[Route("/send-notification", methods: ["POST"])]
    public function sendNotification(Request $request, MessageBusInterface $messageBus): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['recipient']) || !isset($data['message'])) {
            return $this->json(['error' => 'Invalid data. "recipient" and "message" are required.'], 400);
        }

        $recipient = $data['recipient'];
        $messageText = $data['message'];
        $subject = $data['subject'] ?? '';

        $notificationMessage = new NotificationMessage($recipient, $messageText, $subject);
        $messageBus->dispatch($notificationMessage);

        return $this->json(['message' => 'Notification sent successfully.']);
    }
}
