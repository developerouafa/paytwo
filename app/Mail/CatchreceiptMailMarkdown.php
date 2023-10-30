<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CatchreceiptMailMarkdown extends Mailable
{
    use Queueable, SerializesModels;

    protected $message;
    protected $nameclient;
    protected $url;
    /**
     * Create a new message instance.
     */
    public function __construct($message, $nameclient, $url)
    {
        $this->message=$message;
        $this->nameclient=$nameclient;
        $this->url=$url;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Catchreceipt Mail Markdown',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.catchreceiptmail',
            with: [
                'message' => $this->message,
                'nameclient' => $this->nameclient,
                'url' => $this->url,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
