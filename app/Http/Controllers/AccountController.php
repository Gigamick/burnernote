<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function settings(): View
    {
        $user = Auth::user();
        $teams = $user->teams()->withCount('members')->get();

        return view('account.settings', compact('user', 'teams'));
    }

    public function updateDefaults(Request $request): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'default_max_expiry_days' => 'required|integer|min:1|max:365',
            'default_min_expiry_days' => 'required|integer|min:1|max:365',
            'default_max_view_limit' => 'required|integer|min:1|max:100',
        ]);

        $validated['default_require_password'] = $request->boolean('default_require_password');

        if ($validated['default_min_expiry_days'] > $validated['default_max_expiry_days']) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Minimum expiry cannot exceed maximum expiry.'], 422);
            }
            return back()->withErrors(['default_min_expiry_days' => 'Minimum expiry cannot exceed maximum expiry.']);
        }

        Auth::user()->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('account.settings')
            ->with('success', 'Defaults updated.');
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $name = $validated['last_name']
            ? $validated['first_name'] . ' ' . $validated['last_name']
            : $validated['first_name'];

        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'] ?? null,
            'name' => $name,
        ]);

        return redirect()->route('account.settings')
            ->with('success', 'Profile updated.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'confirmation' => 'required|in:DELETE',
        ]);

        $user = Auth::user();
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Your account has been deleted.');
    }

    public function inbox(): View
    {
        $user = Auth::user();
        $notes = $user->burnMeNotes()->paginate(20);

        return view('account.inbox', compact('user', 'notes'));
    }

    public function viewInboxNote(int $noteId): View
    {
        $user = Auth::user();

        $note = Note::find($noteId);

        // Note doesn't exist (already deleted or never existed)
        if (!$note) {
            return view('deleted-note', ['fromInbox' => true]);
        }

        // Verify ownership
        if ($note->recipient_user_id !== $user->id || !$note->is_burn_me) {
            abort(404);
        }

        // Check if expired
        if ($note->isExpired()) {
            $note->delete();
            return view('expired-note');
        }

        // Check if already fully viewed
        if (!$note->hasViewsRemaining()) {
            return view('deleted-note');
        }

        // Mark as read
        $note->markAsRead();

        // Decrypt server-side encryption layer
        try {
            $decrypted = Crypt::decryptString($note->note);
        } catch (DecryptException $e) {
            return view('deleted-note');
        }

        // Get the client key
        $clientKey = null;
        if ($note->encrypted_client_key) {
            try {
                $clientKey = Crypt::decryptString($note->encrypted_client_key);
            } catch (DecryptException $e) {
                // Key couldn't be decrypted
            }
        }

        // Increment view count first, then calculate remaining
        $note->incrementViewCount();
        $remainingViews = $note->remainingViews();

        // Delete if max views reached
        if ($note->shouldBeDeleted()) {
            $note->receipt()?->markAsViewed();
            $note->delete();
        }

        return view('account.inbox-note', [
            'encryptedNote' => $decrypted,
            'clientKey' => $clientKey,
            'remainingViews' => $remainingViews,
        ]);
    }

    public function updateBurnMe(Request $request): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'burn_me_enabled' => 'boolean',
            'burn_me_slug' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[a-z0-9]([a-z0-9-]*[a-z0-9])?$/',
                'unique:users,burn_me_slug,' . $user->id,
            ],
        ], [
            'burn_me_slug.regex' => 'URL must be lowercase letters, numbers, and hyphens only. Cannot start or end with a hyphen.',
            'burn_me_slug.unique' => 'This URL is already taken.',
        ]);

        $enabled = $request->boolean('burn_me_enabled');
        $slug = $validated['burn_me_slug'] ?? null;

        // If enabling but no slug provided, generate a random 6-character string
        if ($enabled && !$slug && !$user->burn_me_slug) {
            do {
                $slug = Str::lower(Str::random(6));
            } while (\App\Models\User::where('burn_me_slug', $slug)->exists());
        }

        $user->update([
            'burn_me_enabled' => $enabled,
            'burn_me_slug' => $slug ?: $user->burn_me_slug,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'slug' => $user->burn_me_slug]);
        }

        return redirect()->route('account.settings')
            ->with('success', 'Burn Me settings updated.');
    }
}
