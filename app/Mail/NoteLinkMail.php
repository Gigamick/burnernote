<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NoteLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $link
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "You've received a private note",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.note-link',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
