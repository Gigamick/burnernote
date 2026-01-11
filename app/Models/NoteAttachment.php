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
    ];

    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class);
    }

    public function getDownloadUrl(): string
    {
        return route('attachments.download', $this);
    }

    public function deleteFromStorage(): void
    {
        Storage::disk('r2')->delete($this->storage_path);
    }
}
