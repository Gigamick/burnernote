<?php

namespace Tests\Feature;

use App\Models\Note;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateNoteTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_create_an_encrypted_note_with_password(): void
    {
        Carbon::setTestNow(now());

        $message = 'Secret Message!';
        $defaultExpiry = 7;

        $response = $this->post('/create-note', [
            'note' => $message,
            'password' => 'secret'
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('note-summary');
        $this->assertNotNull($note = Note::first());
        $this->assertNotNull($note->token);
        $this->assertNotNull($note->password);
        $this->assertEquals(now()->addDays($defaultExpiry)->toDateTimeString(), $note->expiry_date->toDateTimeString());
        $this->assertEquals($message, Crypt::decryptString($note->note));
        $response->assertViewHas('note', function (Note $viewNote) use ($note) {
            return $note->id === $viewNote->id;
        });

        Carbon::setTestNow();
    }

    #[Test]
    public function note_creation_validates_input(): void
    {
        $response = $this->post('/create-note', [
            'note' => '',
        ]);

        $response->assertSessionHasErrors(['note']);
    }

    #[Test]
    public function note_creation_rejects_too_long_content(): void
    {
        $response = $this->post('/create-note', [
            'note' => str_repeat('a', 50001),
        ]);

        $response->assertSessionHasErrors(['note']);
    }
}
