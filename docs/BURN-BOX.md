# Burn Box Feature Documentation

Burn Box is a public inbox feature that allows registered users to receive encrypted, self-destructing notes from anyone.

## Overview

- **Public URL**: Each user gets a unique shareable link (`/b/{slug}`)
- **Zero-Knowledge**: Notes are encrypted client-side before submission
- **Self-Destructing**: Notes are deleted after being viewed once
- **Email Notifications**: Recipients are notified when they receive a note
- **In-App Inbox**: View and manage received notes from the account dashboard

## User Experience

### For Recipients (Registered Users)

1. **Enable Burn Box**
   - Navigate to Account Settings
   - Toggle "Enable Burn Box" to on
   - A unique URL is automatically generated (e.g., `burnernote.com/b/abc123`)
   - Optionally customize the URL slug

2. **Share Your Link**
   - Copy the Burn Box URL
   - Share via email, messaging apps, social media, etc.

3. **Receive Notes**
   - Get email notification when someone sends a note
   - View unread count badge in navigation menu
   - Access notes from the Burn Box inbox

4. **View Notes**
   - Click on a note to decrypt and view
   - Note is marked as read
   - After viewing, note is permanently deleted

5. **Manage Settings**
   - Toggle Burn Box on/off (disabled = 404 on public URL)
   - Regenerate URL to invalidate old links
   - All changes autosave

### For Senders (Anyone)

1. Visit the recipient's Burn Box URL
2. Enter your message in the text area
3. Click "Encrypt & Send"
4. See encryption confirmation (1-second visual feedback)
5. Note is submitted and success page shown

## Technical Implementation

### Database Schema

#### Users Table Additions

| Column | Type | Description |
|--------|------|-------------|
| `burn_me_slug` | string(50), nullable, unique | URL slug for public link |
| `burn_me_enabled` | boolean, default false | Whether Burn Box is active |

#### Notes Table Additions

| Column | Type | Description |
|--------|------|-------------|
| `recipient_user_id` | foreignId, nullable | Links to receiving user |
| `is_burn_me` | boolean, default false | Identifies Burn Box notes |
| `read_at` | timestamp, nullable | When note was first viewed |

Index: `['recipient_user_id', 'is_burn_me', 'read_at']`

### Routes

```php
// Public routes (no auth required)
Route::get('/b/{slug}', [BurnMeController::class, 'show'])->name('burn-me.show');
Route::post('/b/{slug}', [BurnMeController::class, 'store'])->name('burn-me.store');

// Authenticated routes
Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('/inbox', [AccountController::class, 'inbox'])->name('inbox');
    Route::get('/inbox/{noteId}', [AccountController::class, 'viewInboxNote'])->name('inbox.view');
    Route::post('/burn-me/update', [AccountController::class, 'updateBurnMe'])->name('burn-me.update');
    Route::post('/burn-me/regenerate', [AccountController::class, 'regenerateBurnMeSlug'])->name('burn-me.regenerate');
});
```

### Controllers

#### BurnMeController

| Method | Route | Description |
|--------|-------|-------------|
| `show($slug)` | GET `/b/{slug}` | Display public form. Returns 404 if disabled. |
| `store($slug)` | POST `/b/{slug}` | Validate, save note, send email. Rate limited: 10/hour per IP. |

#### AccountController (Burn Box methods)

| Method | Route | Description |
|--------|-------|-------------|
| `inbox()` | GET `/account/inbox` | List received notes, paginated, newest first |
| `viewInboxNote($noteId)` | GET `/account/inbox/{noteId}` | Decrypt and display note, mark as read |
| `updateBurnMe()` | POST `/account/burn-me/update` | Toggle enabled, update slug (AJAX) |
| `regenerateBurnMeSlug()` | POST `/account/burn-me/regenerate` | Generate new random slug |

### Models

#### User Model

```php
// Relationships
public function burnMeNotes(): HasMany
public function unreadBurnMeNotes(): HasMany

// Attributes
public function getBurnMeUrlAttribute(): string

// Methods
public function generateBurnMeSlug(): string
```

#### Note Model

```php
// Relationships
public function recipient(): BelongsTo

// Methods
public function markAsRead(): void
```

### Views

| Path | Purpose |
|------|---------|
| `burn-me/form.blade.php` | Public submission form with client-side encryption |
| `burn-me/success.blade.php` | Confirmation page after submission |
| `account/inbox.blade.php` | List of received notes with read/unread status |
| `account/inbox-note.blade.php` | View individual encrypted note |
| `emails/burn-me-note.blade.php` | Email notification template |

### Email Notification

**Mailable**: `App\Mail\BurnMeNoteMail`

**Triggered**: When a note is submitted to a user's Burn Box

**Contents**:
- Subject: "Someone sent you a private note"
- Direct link to view the note (with decryption key in URL fragment)
- Link to Burn Box inbox
- Security notice about one-time viewing

## Security

### Encryption

- **Algorithm**: AES-256-GCM
- **Key Generation**: Client-side using Web Crypto API
- **Key Storage**: Included in URL fragment (never sent to server)
- **Zero-Knowledge**: Server only stores encrypted ciphertext

### Rate Limiting

- 10 submissions per hour per IP address
- Prevents spam/abuse of public endpoints

### Access Control

- Disabled Burn Box returns 404 (no information leak)
- Regenerating slug immediately invalidates old URLs
- Notes can only be viewed by the authenticated recipient

### Note Lifecycle

1. Note created with 7-day expiry and 1 view limit
2. First view increments view count and sets `read_at`
3. After view limit reached, note content is deleted
4. Expired notes are cleaned up by scheduled task

## Fixed Note Settings

Burn Box notes use fixed settings (not customizable by sender):

| Setting | Value |
|---------|-------|
| Expiry | 7 days |
| Max Views | 1 |
| Password | None |
| Encryption | Required (client-side) |

## File Reference

### Created Files

- `app/Http/Controllers/BurnMeController.php`
- `app/Mail/BurnMeNoteMail.php`
- `resources/views/burn-me/form.blade.php`
- `resources/views/burn-me/success.blade.php`
- `resources/views/account/inbox.blade.php`
- `resources/views/account/inbox-note.blade.php`
- `resources/views/emails/burn-me-note.blade.php`
- `database/migrations/XXXX_add_burn_me_to_users_table.php`
- `database/migrations/XXXX_add_recipient_to_notes_table.php`
- `database/migrations/XXXX_change_burn_me_uuid_to_slug_on_users_table.php`

### Modified Files

- `app/Models/User.php` - Added Burn Box relationships and methods
- `app/Models/Note.php` - Added recipient relationship and read tracking
- `app/Http/Controllers/AccountController.php` - Added inbox and settings methods
- `routes/web.php` - Added Burn Box routes
- `resources/views/account/settings.blade.php` - Added Burn Box settings section
- `resources/views/layouts/app.blade.php` - Added Burn Box link with unread badge

## UI/UX Features

### Autosave

Settings changes (toggle, URL slug) save automatically via AJAX with a "Saved" indicator.

### Real-time Slug Formatting

URL slug input automatically:
- Converts spaces to hyphens
- Lowercases all characters
- Strips special characters
- Removes duplicate hyphens

### Visual Encryption Confirmation

When submitting a note, the button shows "Encrypted!" for 1 second before form submission, providing user confidence that encryption occurred.

### Unread Badge

Navigation menu shows unread note count next to "Burn Box" link.

## Naming Convention

**User-facing**: "Burn Box" (used in all UI text, emails)

**Internal/Code**: "burn_me" (database columns, controller names, route names)

This separation allows for potential future rebranding without code changes.
