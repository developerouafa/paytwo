<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class newaccountclient extends Mailable
{
    use Queueable, SerializesModels;

    protected $messagenewaccount;
    protected $nameclient;
    protected $url;
    /**
     * Create a new message instance.
     */
    public function __construct($messagenewaccount, $nameclient, $url)
    {
        $this->messagenewaccount=$messagenewaccount;
        $this->nameclient=$nameclient;
        $this->url=$url;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Newaccountclient',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.newaccountclientemail',
            with: [
                'message' => $this->messagenewaccount,
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
