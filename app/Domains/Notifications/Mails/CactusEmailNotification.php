<?php

namespace App\Domains\Notifications\Mails;

use App\Domains\Notifications\Models\Sender;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CactusEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private Sender $sender;
    private string $greeting;
    private string $emailSubject;
    private string $body;
    private array $emailAttachments;
    private array $action;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Sender $sender, string $subject, string $greeting, string $body, array $emailAttachments = [], array $action = [])
    {
        $this->sender           = $sender;
        $this->emailSubject     = $subject;
        $this->greeting         = $greeting;
        $this->body             = $body;
        $this->emailAttachments = $emailAttachments;
        $this->action           = $action;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $message = new MailMessage();

        $message = $message->subject($this->emailSubject)
                           ->greeting($this->greeting)
                           ->from($this->sender->getEmail(), $this->sender->getName())
                           ->line($this->body)
                           ->salutation('Με εκτίμηση, <br> ' . $this->sender->getName())
                           ->action($this->action['text'] ?? null, $this->action['url'] ?? null);

        return $message;
    }
}
