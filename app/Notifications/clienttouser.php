<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class clienttouser extends Notification implements ShouldQueue
{
    use Queueable;

    private $invoice_id;
    public $created_at;
    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($invoice_id, $message)
    {
        $this->invoice_id = $invoice_id;
        $this->message = $message;
        $this->created_at = date('Y-m-d H:i:s');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'invoice_id' => $this->invoice_id,
            'message' => $this->message,
            'created_at' => $this->created_at,
        ];
    }
}
