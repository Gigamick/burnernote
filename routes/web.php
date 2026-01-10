<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\MagicLinkController;
use App\Http\Controllers\BurnMeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamMemberController;
use App\Models\Receipt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [MagicLinkController::class, 'showLogin'])->name('login');
    Route::get('/register', [MagicLinkController::class, 'showRegister'])->name('register');
    Route::post('/login', [MagicLinkController::class, 'sendMagicLink']);
    Route::get('/auth/check-email', [MagicLinkController::class, 'checkEmail'])->name('auth.check-email');
    Route::get('/auth/verify/{token}', [MagicLinkController::class, 'verify'])->name('auth.verify');
});

Route::middleware('auth')->group(function () {
    Route::get('/auth/complete-profile', [MagicLinkController::class, 'showCompleteProfile'])->name('auth.complete-profile');
    Route::post('/auth/complete-profile', [MagicLinkController::class, 'completeProfile']);
    Route::get('/auth/choose-mode', [MagicLinkController::class, 'showChooseMode'])->name('auth.choose-mode');
    Route::post('/auth/choose-mode', [MagicLinkController::class, 'chooseMode'])->name('auth.choose-mode.store');
});

Route::post('/logout', [MagicLinkController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Team invitation (public route)
Route::get('/invitation/{token}', [TeamMemberController::class, 'acceptInvitation'])->name('invitation.accept');

// Team routes
Route::middleware('auth')->group(function () {
    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
    Route::get('/teams/{team}/settings', [TeamController::class, 'settings'])->name('teams.settings');
    Route::put('/teams/{team}/settings', [TeamController::class, 'updateSettings'])->name('teams.settings.update');
    Route::get('/teams/{team}/members', [TeamController::class, 'members'])->name('teams.members');
    Route::get('/teams/{team}/audit-log', [TeamController::class, 'auditLog'])->name('teams.audit-log');
    Route::delete('/teams/{team}/audit-log', [TeamController::class, 'clearAuditLog'])->name('teams.audit-log.clear');
    Route::post('/teams/{team}/invite', [TeamMemberController::class, 'invite'])->name('teams.invite');
    Route::delete('/teams/{team}/members/{member}', [TeamMemberController::class, 'remove'])->name('teams.members.remove');
    Route::delete('/teams/{team}/invitations/{invitation}', [TeamMemberController::class, 'cancelInvitation'])->name('teams.invitations.cancel');
});

// Account routes
Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('/settings', [AccountController::class, 'settings'])->name('settings');
    Route::put('/profile', [AccountController::class, 'updateProfile'])->name('profile.update');
    Route::put('/defaults', [AccountController::class, 'updateDefaults'])->name('defaults.update');
    Route::delete('/', [AccountController::class, 'destroy'])->name('destroy');

    // Burn Me Inbox
    Route::get('/inbox', [AccountController::class, 'inbox'])->name('inbox');
    Route::get('/inbox/{noteId}', [AccountController::class, 'viewInboxNote'])->name('inbox.view');
    Route::put('/burn-me', [AccountController::class, 'updateBurnMe'])->name('burn-me.update');
});

// Burn Me public routes
Route::get('/b/{slug}', [BurnMeController::class, 'show'])->name('burn-me.show');
Route::post('/b/{slug}', [BurnMeController::class, 'store'])->name('burn-me.store');

Route::get('/', function () {
    $legacyCount = (int) env('LEGACY_BURN_COUNT', 0);
    try {
        $newCount = Receipt::whereIn('status', ['viewed', 'expired'])->count();
    } catch (\Exception $e) {
        $newCount = 0;
    }
    $burnCount = $legacyCount + $newCount;

    // Get user's team if logged in
    $team = null;
    $user = null;
    $isIndividual = false;

    if (Auth::check()) {
        $user = Auth::user();
        $team = $user->teams()->first();
        $isIndividual = $user->account_mode === 'individual';
    }

    return view('welcome', compact('burnCount', 'team', 'user', 'isIndividual'));
});

Route::post('/create-note', [NoteController::class, 'create']);
Route::post('/submit-password', [NoteController::class, 'password']);
Route::get('/n/{token}', [NoteController::class, 'show']);
Route::get('/v/{token}', [NoteController::class, 'verify']);

Route::view('/about', 'about');
Route::view('/pro', 'pro');
Route::view('/privacy', 'privacy');
Route::view('/contact', 'contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Admin
Route::get('/admin', [AdminController::class, 'dashboard'])->middleware('auth')->name('admin.dashboard');

Route::post('/send-email', [EmailController::class, 'sendemail']);

Route::get('/r/{token}', [NoteController::class, 'receipt']);


