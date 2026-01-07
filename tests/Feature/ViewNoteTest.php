<?php

namespace Tests\Feature;

use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ViewNoteTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function trying_to_access_note_url_shows_disclaimer(): void
    {
        $note = Note::factory()->create();

        $response = $this->get("/v/{$note->token}");

        $response->assertOk();
        $response->assertViewIs('disclaimer');
        $response->assertViewHas('token', fn ($viewToken) => $note->token === $viewToken);
    }

    #[Test]
    public function trying_to_view_notes_that_does_not_exist_shows_error_page(): void
    {
        $note = Note::factory()->create();
        $note->delete();

        $response = $this->get("/n/{$note->token}");

        $response->assertOk();
        $response->assertViewIs('deleted-note');
        $response->assertSee("note you");
    }

    #[Test]
    public function trying_to_view_expired_notes_deletes_note_and_shows_expired_page(): void
    {
        $note = Note::factory()->create([
            'expiry_date' => now()->subDays(360),
        ]);
        $token = $note->token;

        $response = $this->get("/n/{$token}");

        $response->assertOk();
        $response->assertViewIs('expired-note');
        $response->assertSee("note you");
        $this->assertNull(Note::where('token', $token)->first());
    }

    #[Test]
    public function trying_to_access_note_with_password_asks_for_password(): void
    {
        $note = Note::factory()->create([
            'password' => Hash::make('secret'),
        ]);

        $response = $this->get("/n/{$note->token}");

        $response->assertOk();
        $response->assertViewIs('enter-password');
        $response->assertViewHas('token', $note->token);
    }

    #[Test]
    public function notes_without_password_can_be_viewed_and_are_deleted(): void
    {
        $message = 'My secret message!';
        $note = Note::factory()->create([
            'note' => Crypt::encryptString($message),
            'password' => null,
        ]);
        $token = $note->token;

        $response = $this->get("/n/{$token}");

        $response->assertOk();
        $response->assertViewIs('note');
        $response->assertViewHasAll(['actualnote' => $message]);
        $this->assertNull(Note::where('token', $token)->first());
    }

    #[Test]
    public function trying_to_access_note_with_wrong_password_shows_error(): void
    {
        $note = Note::factory()->create([
            'password' => Hash::make('secret'),
        ]);

        $response = $this->from("/n/{$note->token}")->post('/submit-password', [
            'password' => 'wrong-password',
            'token' => $note->token,
        ]);

        $response->assertRedirect("/n/{$note->token}");
        $response->assertSessionHas('error', 'Incorrect password');
    }

    #[Test]
    public function notes_with_password_can_be_viewed_and_are_deleted(): void
    {
        $message = 'secret message!';
        $note = Note::factory()->create([
            'note' => Crypt::encryptString($message),
            'password' => Hash::make('secret'),
        ]);
        $token = $note->token;

        $response = $this->post('/submit-password', [
            'token' => $token,
            'password' => 'secret',
        ]);

        $response->assertOk();
        $response->assertViewIs('note');
        $response->assertViewHasAll(['actualnote' => $message]);
        $this->assertNull(Note::where('token', $token)->first());
    }
}
