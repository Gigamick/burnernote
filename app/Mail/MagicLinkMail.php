<?php

namespace App\Mail;

use App\Models\MagicLinkToken;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MagicLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public MagicLinkToken $token,
        public bool $isRegistration = false
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->isRegistration ? 'Complete your Burner Note account' : 'Sign in to Burner Note',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.magic-link',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
