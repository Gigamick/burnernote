<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\MagicLinkMail;
use App\Models\MagicLinkToken;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MagicLinkController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function sendMagicLink(Request $request): RedirectResponse
    {
        $isRegistration = $request->boolean('register');

        $rules = ['email' => 'required|email'];
        if ($isRegistration) {
            $rules['cf-turnstile-response'] = 'required';
        }
        $request->validate($rules, [
            'cf-turnstile-response.required' => 'Please complete the security check.',
        ]);

        // Verify Turnstile token with Cloudflare
        if ($isRegistration) {
            $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => config('services.turnstile.secret_key'),
                'response' => $request->input('cf-turnstile-response'),
                'remoteip' => $request->ip(),
            ]);

            if (!$response->json('success')) {
                return back()->withErrors(['cf-turnstile-response' => 'Security check failed. Please try again.'])->withInput();
            }
        }

        $email = strtolower($request->email);

        // Check if user exists
        $existingUser = User::where('email', $email)->first();

        if ($isRegistration && $existingUser) {
            return back()->withErrors(['email' => 'An account with this email already exists. Please log in instead.']);
        }

        if (!$isRegistration && !$existingUser) {
            return back()->withErrors(['email' => 'No account found with this email. Please create an account first.']);
        }

        // Create user if registering
        if ($isRegistration) {
            User::create([
                'email' => $email,
                'name' => explode('@', $email)[0],
                'profile_completed' => false,
            ]);
        }

        // Delete any existing unused tokens for this email
        MagicLinkToken::where('email', $email)
            ->whereNull('used_at')
            ->delete();

        // Create magic link token
        $token = MagicLinkToken::create([
            'email' => $email,
            'token' => Str::random(64),
            'expires_at' => now()->addMinutes(15),
            'ip_address' => $request->ip(),
            'is_registration' => $isRegistration,
        ]);

        // Send email
        Mail::to($email)->send(new MagicLinkMail($token, $isRegistration));

        return redirect()->route('auth.check-email')
            ->with('email', $email)
            ->with('is_registration', $isRegistration);
    }

    public function verify(string $token): RedirectResponse
    {
        $magicLink = MagicLinkToken::where('token', $token)->first();

        if (!$magicLink || !$magicLink->isValid()) {
            return redirect()->route('login')
                ->with('error', 'This link is invalid or has expired. Please request a new one.');
        }

        $user = User::where('email', $magicLink->email)->firstOrFail();
        $isRegistration = $magicLink->is_registration ?? false;

        $magicLink->markAsUsed();
        $user->update(['last_login_at' => now()]);

        Auth::login($user, remember: true);

        // If new registration, redirect to complete profile
        if ($isRegistration || !$user->profile_completed) {
            return redirect()->route('auth.complete-profile');
        }

        return redirect()->intended('/');
    }

    public function checkEmail(): View
    {
        return view('auth.check-email');
    }

    public function showCompleteProfile(): View
    {
        return view('auth.complete-profile');
    }

    public function completeProfile(Request $request): RedirectResponse
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
            'profile_completed' => true,
        ]);

        // Redirect to choose account mode
        return redirect()->route('auth.choose-mode');
    }

    public function showChooseMode(): View
    {
        return view('auth.choose-mode');
    }

    public function chooseMode(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'mode' => 'required|in:individual,team',
        ]);

        $user = Auth::user();
        $user->update(['account_mode' => $validated['mode']]);

        if ($validated['mode'] === 'team') {
            return redirect()->route('teams.create')->with('onboarding', true);
        }

        return redirect('/')->with('success', 'Welcome to Burner Note Pro!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
