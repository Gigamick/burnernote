<?php

namespace App\Models;

use App\Mail\NoteViewedMail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Receipt extends Model
{
    protected $fillable = [
        'token',
        'status',
        'notify_email',
        'viewed_at',
        'expires_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function markAsViewed(): void
    {
        $this->update([
            'status' => 'viewed',
            'viewed_at' => now(),
        ]);

        if ($this->notify_email) {
            Mail::to($this->notify_email)->send(new NoteViewedMail($this));
        }
    }

    public function markAsExpired(): void
    {
        $this->update(['status' => 'expired']);
    }
}
