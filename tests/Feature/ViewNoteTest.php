<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use App\Models\Note;
use Tests\TestCase;

class ViewNoteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function trying_to_access_note_url_shows_disclaimer() {
        $note = Note::factory()->create();

        $response = $this->get("/v/{$note->token}");

        $response->assertOk();
        $response->assertViewIs('disclaimer');
        $response->assertViewHas('token', function  ($viewToken) use ($note) {
            return $note->token === $viewToken;
        });
    }

    /** @test */
    function trying_to_view_notes_that_does_not_exists_shows_error_page() {
        $note = Note::factory()->create();
        $note->delete();

        $response = $this->get("/n/{$note->token}");

        $response->assertOk();
        $response->assertViewIs('deleted-note');
        $response->assertSeeText("The note you're trying to access has expired", $escaped = false);
    }

    /** @test */
    function trying_to_view_notes_that_are_expired_deletes_note_contents() {
        $expired_note = Note::factory()->create([
            'expiry_date' => now()->subDays(360),
        ])->toArray();

        $response = $this->get("/n/{$expired_note['token']}");

        $response->assertOk();
        $this->assertEquals([
            'user_id' => null,
            'password' => '',
            'token' => '',
            'note' => '',
        ], $difference = array_diff_assoc(Note::first()->toArray(), $expired_note));
        $response->assertViewIs('expired-note');
        $response->assertSeeText("The note you're trying to access has expired", $escaped = false);
    }

    /** @test */
    function trying_to_access_note_with_passward_asks_for_password() {
        $note = Note::factory()->create([
            'password' => 'secret',
        ]);

        $response = $this->get("/n/{$note->token}");

        $response->assertOk();
        $response->assertViewIs('enter-password');
        $response->assertViewHas('token');
    }

    /** @test */
    function notes_without_password_can_be_viewed_and_are_removed() {
        $note = Note::factory()->create([
            'note'     => encrypt($message = 'My secret message!', $serialize = false),
            'password' => null,
        ])->toArray();

        $response = $this->get("/n/{$note['token']}");

        $response->assertOk();
        $this->assertEquals([
            'user_id' => null,
            'token' => '',
            'note' => '',
        ], $difference = array_diff_assoc(Note::first()->toArray(), $note));
        $response->assertViewIs('note');
        $response->assertViewHas('note');
        $response->assertViewHasAll(['actualnote' => $message]);
    }

    /** @test */
    function trying_to_access_note_with_wrong_password_shows_error() {
        $note = Note::factory()->create([
            'password' => Hash::make('secret'),
        ]);

        $response = $this->from("/n/{$note->token}")->post('/submit-password', [
            'password' => 'wrong-password',
            'token'    => $note->token,
        ]);

        $response->assertRedirect("/n/{$note->token}");
        $response->assertSessionHas('success', 'Incorrect password');
    }

    /** @test */
    function notes_with_password_can_be_viewed() {
        $note = Note::factory()->create([
            'note'     => encrypt($message = 'secret message!', $serialize = false),
            'password' => Hash::make('secret'),
        ]);

        $response = $this->followingRedirects()->post('/submit-password', [
            'token'    => $note->token,
            'password' => 'secret',
        ]);

        $this->assertEquals(null, $note->fresh()->password);
        $response->assertOk();
        $response->assertViewIs('note');
        $response->assertViewHas('note');
        $response->assertViewHasAll(['actualnote' => $message]);
    }
}
