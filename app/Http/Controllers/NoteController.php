<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNoteRequest;
use App\Models\Note;
use App\Models\Receipt;
use App\Models\TeamAuditLog;
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
        $expiryDate = Carbon::now()->addDays($expiry);
        $clientEncrypted = $request->has('client_encrypted');
        $team = $request->team;

        $receipt = Receipt::create([
            'token' => Str::uuid(),
            'status' => 'pending',
            'notify_email' => $validated['notify_email'] ?? null,
            'expires_at' => $expiryDate,
            'team_id' => $team?->id,
            'user_id' => Auth::id(),
        ]);

        // For client-encrypted notes, the content is already encrypted client-side
        // We still wrap with server-side encryption for at-rest security
        $noteContent = $clientEncrypted
            ? Crypt::encryptString($validated['note']) // Store client-encrypted blob, wrapped with server encryption
            : Crypt::encryptString(strip_tags($validated['note'])); // Legacy: server encrypts plaintext

        $note = Note::create([
            'note' => $noteContent,
            'password' => isset($validated['password']) ? Hash::make($validated['password']) : null,
            'client_encrypted' => $clientEncrypted,
            'max_views' => (int) ($validated['max_views'] ?? 1),
            'user_id' => Auth::id(),
            'team_id' => $team?->id,
            'token' => Str::uuid(),
            'receipt_token' => $receipt->token,
            'expiry_date' => $expiryDate,
        ]);

        // Log to team audit if team note
        if ($team) {
            TeamAuditLog::log($team, 'note_created', Auth::user(), [
                'note_token' => $note->token,
                'expiry_days' => $expiry,
                'max_views' => $note->max_views,
                'has_password' => !empty($validated['password']),
                'recipient_email' => $validated['notify_email'] ?? null,
            ]);
        }

        return view('note-summary', compact('note', 'receipt'));
    }

    public function verify(string $token): View
    {
        $note = Note::where('token', $token)->first();

        if (!$note) {
            return view('deleted-note');
        }

        $remainingViews = $note->remainingViews();

        return view('disclaimer', compact('token', 'remainingViews'));
    }

    public function show(string $token): View
    {
        $note = Note::where('token', $token)->first();

        if (!$note) {
            return view('deleted-note');
        }

        if ($note->isExpired()) {
            $this->markReceiptExpired($note);
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

    public function receipt(string $token): View
    {
        $receipt = Receipt::where('token', $token)->first();

        if (!$receipt) {
            return view('receipt-not-found');
        }

        if ($receipt->status === 'pending' && $receipt->expires_at->isPast()) {
            $receipt->markAsExpired();
        }

        return view('receipt', compact('receipt'));
    }

    private function displayAndDeleteNote(Note $note): View
    {
        try {
            $decrypted = Crypt::decryptString($note->note);
        } catch (DecryptException $e) {
            Log::error('Failed to decrypt note', ['note_id' => $note->id]);
            $note->delete();
            return view('deleted-note');
        }

        // Log to team audit if team note
        if ($note->team_id) {
            $team = \App\Models\Team::find($note->team_id);
            if ($team) {
                TeamAuditLog::log($team, 'note_viewed', null, [
                    'note_token' => $note->token,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            }
        }

        // Increment view count
        $note->incrementViewCount();
        $remainingViews = $note->remainingViews();
        $clientEncrypted = $note->client_encrypted;

        // Delete note if max views reached
        if ($note->shouldBeDeleted()) {
            $this->markReceiptViewed($note);
            $note->delete();
        }

        if ($clientEncrypted) {
            // For client-encrypted notes, pass the client-encrypted blob to view
            // Client will decrypt with key from URL fragment
            return view('note-encrypted', [
                'encryptedNote' => $decrypted,
                'remainingViews' => $remainingViews,
            ]);
        }

        // Legacy: server-decrypted plaintext
        return view('note', [
            'actualnote' => $decrypted,
            'remainingViews' => $remainingViews,
        ]);
    }

    private function markReceiptViewed(Note $note): void
    {
        if ($note->receipt_token) {
            $receipt = Receipt::where('token', $note->receipt_token)->first();
            $receipt?->markAsViewed();
        }
    }

    private function markReceiptExpired(Note $note): void
    {
        if ($note->receipt_token) {
            $receipt = Receipt::where('token', $note->receipt_token)->first();
            $receipt?->markAsExpired();
        }
    }
}
