<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use App\Models\Note;
use Tests\TestCase;
use Mockery;

class CreateNoteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function user_can_create_an_encrypted_note_with_password() {
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
        $this->assertEquals(now()->addDays($defaultExpiry), $note->expiry_date);
        $this->assertEquals($message, Crypt::decryptString($note->note));
        $response->assertViewHas('note', function (Note $viewNote) use ($note) {
            return $note->id === $viewNote->id;
        });
    }
}
