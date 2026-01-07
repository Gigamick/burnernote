<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'note',
        'password',
        'client_encrypted',
        'max_views',
        'view_count',
        'token',
        'receipt_token',
        'user_id',
        'expiry_date',
    ];

    protected $casts = [
        'expiry_date' => 'datetime',
        'client_encrypted' => 'boolean',
        'max_views' => 'integer',
        'view_count' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool
    {
        return $this->expiry_date->isPast();
    }

    public function receipt(): ?Receipt
    {
        return Receipt::where('token', $this->receipt_token)->first();
    }

    public function remainingViews(): int
    {
        return max(0, $this->max_views - $this->view_count);
    }

    public function hasViewsRemaining(): bool
    {
        return $this->remainingViews() > 0;
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    public function shouldBeDeleted(): bool
    {
        return $this->view_count >= $this->max_views;
    }
}
