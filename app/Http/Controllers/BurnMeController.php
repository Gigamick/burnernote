<?php

namespace App\Http\Controllers;

use App\Http\Requests\BurnMeNoteRequest;
use App\Mail\BurnMeNoteMail;
use App\Models\Note;
use App\Models\Receipt;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BurnMeController extends Controller
{
    public function show(string $slug): View
    {
        $recipient = User::where('burn_me_slug', $slug)
            ->where('burn_me_enabled', true)
            ->firstOrFail();

        return view('burn-me.form', [
            'recipient' => $recipient,
            'slug' => $slug,
        ]);
    }

    public function store(BurnMeNoteRequest $request, string $slug): View
    {
        $recipient = User::where('burn_me_slug', $slug)
            ->where('burn_me_enabled', true)
            ->firstOrFail();

        // Rate limiting: 10 notes per hour per IP
        $key = 'burn-me:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 10)) {
            abort(429, 'Too many notes submitted. Please try again later.');
        }
        RateLimiter::hit($key, 3600);

        $validated = $request->validated();

        // Fixed settings for Burn Me notes
        $expiryDays = 7;
        $maxViews = 1;
        $expiryDate = Carbon::now()->addDays($expiryDays);

        // Create receipt
        $receipt = Receipt::create([
            'token' => Str::uuid(),
            'status' => 'pending',
            'notify_email' => $recipient->email,
            'expires_at' => $expiryDate,
            'user_id' => null,
        ]);

        // Wrap client-encrypted content with server-side encryption
        $noteContent = Crypt::encryptString($validated['note']);

        // Store the client key (encrypted) so we can include it in email
        $encryptedClientKey = isset($validated['client_key'])
            ? Crypt::encryptString($validated['client_key'])
            : null;

        // Create the note
        $note = Note::create([
            'note' => $noteContent,
            'password' => null,
            'client_encrypted' => true,
            'max_views' => $maxViews,
            'user_id' => null,
            'team_id' => null,
            'recipient_user_id' => $recipient->id,
            'is_burn_me' => true,
            'token' => Str::uuid(),
            'receipt_token' => $receipt->token,
            'encrypted_client_key' => $encryptedClientKey,
            'expiry_date' => $expiryDate,
        ]);

        // Send email notification to recipient
        Mail::to($recipient->email)->queue(new BurnMeNoteMail($note, $recipient));

        return view('burn-me.success', [
            'recipient' => $recipient,
        ]);
    }
}
