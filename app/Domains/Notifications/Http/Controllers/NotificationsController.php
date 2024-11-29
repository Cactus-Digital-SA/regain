<?php

namespace App\Domains\Notifications\Http\Controllers;

use App\Domains\Notifications\Http\Requests\SendNotificationRequest;
use App\Domains\Notifications\Models\CactusNotification;
use App\Domains\Notifications\Models\EmailNotification;
use App\Domains\Notifications\Models\Recipient;
use App\Domains\Notifications\Services\NotificationsService;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Response;

class NotificationsController extends Controller
{
    private CactusNotification $cactusNotification;
    private NotificationsService $notificationsService;

    public function __construct(NotificationsService $notificationsService, CactusNotification $cactusNotification)
    {
        $this->cactusNotification   = $cactusNotification;
        $this->notificationsService = $notificationsService;
    }

    /**
     * @throws Exception
     * Test Send Email
     */
    public function sendEmail(SendNotificationRequest $request)
    {
        $recipients = [];
        foreach ($request['recipients'] as $recipient) {
            $recipients[] = new Recipient($recipient['email'], $recipient['name']);
        }

        $emailDTO = new EmailNotification();
        $emailDTO->setRecipients($recipients);
        $emailDTO->setSubject($request['subject'] ?? '');
        $emailDTO->setGreeting($request['greeting'] ?? '');
        $emailDTO->setBody($request['body'] ?? '');

        $this->cactusNotification->add($emailDTO);

        $this->notificationsService->send($this->cactusNotification);

        return new Response(['message' => 'send'], 200);
    }
}
