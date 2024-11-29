<?php

namespace App\Domains\Notifications\Models;

use App\Domains\Notifications\Mails\CactusEmailNotification;
use App\Domains\Notifications\NotificationInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class EmailNotification implements NotificationInterface
{
    private Sender $sender;
    /**
     * @var Recipient []
     */
    private array $recipients = [];
    private string $subject;
    private string $greeting;
    private string $body;
    private array $attachments = [];
    private string $actionText;
    private string $actionUrl;

    public function setRecipient(Recipient $recipient): void
    {
        $this->recipients[] = $recipient;
    }

    public function setAction($text, $url): void
    {
        $this->actionText = $text;
        $this->actionUrl  = $url;
    }

    public function prepare(): void
    {
        $current_time    = Carbon::now();
        $current_hour    = $current_time->hour;
        $greetingMessage = $current_hour >= 12 ? 'Καλησπέρα σας,' : 'Καλημέρα σας,';
        $this->setGreeting($greetingMessage);

        $sender = new Sender('no-replay@cactusweb.gr', 'Cactus');
        $this->setSender($sender);
    }

    public function send(): Response
    {
        foreach ($this->getRecipients() as $recipient) {
            try {
                Notification::route('mail',
                    $recipient->getEmail())
                            ->notify(new CactusEmailNotification(
                                $this->getSender(),
                                $this->getSubject(),
                                $this->getGreeting(),
                                $this->getBody(),
                                $this->getAttachments(),
                                $this->getAction()
                            ));

//                Mail::to($recipient->getEmail())->send(new CactusEmail(
//                    $this->getSender(),
//                    $this->getSubject(),
//                    $this->getGreeting(),
//                    $this->getBody(),
//                    $this->getAttachments()
//                ));
            } catch (Exception $e) {
                Log::error('Notification Error: ' . $e);

                return new Response(['message' => ''], 500);
            }
        }

        return new Response(['message' => 'send'], 200);
    }

    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * @throws Exception
     */
    public function setRecipients(array $recipients): void
    {
        foreach ($recipients as $recipient) {
            if (!($recipient instanceof Recipient)) {
                throw new Exception("Όλα τα στοιχεία στον πίνακα θα πρέπει να είναι τύπου Recipient.");
            }
        }

        $this->recipients = $recipients;
    }

    public function getSender(): Sender
    {
        return $this->sender;
    }

    public function setSender(Sender $sender): EmailNotification
    {
        $this->sender = $sender;

        return $this;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function getGreeting(): string
    {
        return $this->greeting;
    }

    public function setGreeting(string $greeting): void
    {
        $this->greeting = $greeting;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getAttachments(): array
    {
        return $this->attachments;
    }

    public function setAttachments(array $attachments): void
    {
        $this->attachments = $attachments;
    }

    public function getAction(): array
    {
        return [
            'text' => $this->actionText ?? null,
            'url'  => $this->actionUrl ?? null,
        ];
    }
}
