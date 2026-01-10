<?php

namespace App\Mail;

use App\Models\Note;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class BurnMeNoteMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $noteUrl;

    public function __construct(
        public Note $note,
        public User $recipient,
    ) {
        // Build the note URL with decrypted client key
        $clientKey = '';
        if ($note->encrypted_client_key) {
            try {
                $clientKey = Crypt::decryptString($note->encrypted_client_key);
            } catch (DecryptException $e) {
                // Key couldn't be decrypted, recipient will need to use inbox
            }
        }

        $this->noteUrl = config('app.url') . '/v/' . $note->token;
        if ($clientKey) {
            $this->noteUrl .= '#key=' . $clientKey;
        }
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Someone sent you a private note',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.burn-me-note',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
