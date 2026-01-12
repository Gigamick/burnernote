<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class NoteAttachment extends Model
{
    protected $fillable = [
        'note_id',
        'encrypted_filename',
        'storage_path',
        'mime_type',
        'size',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class);
    }

    public function getDownloadUrl(): string
    {
        return route('attachments.download', $this);
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function markForDeletion(int $minutes = 10): void
    {
        $this->update(['expires_at' => now()->addMinutes($minutes)]);
    }

    public function deleteFromStorage(): void
    {
        Storage::disk('r2')->delete($this->storage_path);
    }
}
