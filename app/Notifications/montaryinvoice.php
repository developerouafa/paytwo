<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class montaryinvoice extends Notification
{
    use Queueable;

    private $user_create_id;
    private $user_create_name;
    private $client;
    private $invoice_id;
    public $created_at;
    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($user_create_id, $user_create_name, $invoice_id, $message)
    {
        $this->user_create_id = $user_create_id;
        $this->user_create_name = $user_create_name;
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
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_create_id' => $this->user_create_id,
            'user_create_name' => $this->user_create_name,
            'client' => $this->client,
            'invoice_id' => $this->invoice_id,
            'message' => $this->message,
            'created_at' => $this->created_at,
        ];
    }
}
