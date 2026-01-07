<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNoteRequest;
use App\Models\Note;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NoteController extends Controller
{
    public function create(CreateNoteRequest $request): View
    {
        $validated = $request->validated();
        $expiry = (int) ($validated['expiry'] ?? 7);

        $note = Note::create([
            'note' => Crypt::encryptString(strip_tags($validated['note'])),
            'password' => isset($validated['password']) ? Hash::make($validated['password']) : null,
            'user_id' => Auth::id(),
            'token' => Str::uuid(),
            'expiry_date' => Carbon::now()->addDays($expiry),
        ]);

        return view('note-summary', compact('note'));
    }

    public function verify(string $token): View
    {
        return view('disclaimer', compact('token'));
    }

    public function show(string $token): View
    {
        $note = Note::where('token', $token)->first();

        if (!$note) {
            return view('deleted-note');
        }

        if ($note->isExpired()) {
            $note->delete();
            return view('expired-note');
        }

        if ($note->password !== null) {
            return view('enter-password', compact('token'));
        }

        return $this->displayAndDeleteNote($note);
    }

    public function password(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'token' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $note = Note::where('token', $request->token)->first();

        if (!$note) {
            return view('deleted-note');
        }

        if (!Hash::check($request->password, $note->password)) {
            return back()->with('error', 'Incorrect password');
        }

        return $this->displayAndDeleteNote($note);
    }

    private function displayAndDeleteNote(Note $note): View
    {
        try {
            $actualnote = Crypt::decryptString($note->note);
        } catch (DecryptException $e) {
            Log::error('Failed to decrypt note', ['note_id' => $note->id]);
            $note->delete();
            return view('deleted-note');
        }

        $note->delete();

        return view('note', compact('actualnote'));
    }
}
