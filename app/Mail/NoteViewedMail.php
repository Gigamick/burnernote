<?php

namespace App\Mail;

use App\Models\Receipt;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NoteViewedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Receipt $receipt
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Burner Note was viewed',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.note-viewed',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
