<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamAuditLog extends Model
{
    protected $fillable = [
        'team_id',
        'user_id',
        'action',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getActionLabelAttribute(): string
    {
        return match ($this->action) {
            'note_created' => 'Created a note',
            'note_viewed' => 'Note was viewed',
            'note_expired' => 'Note expired',
            'member_invited' => 'Invited a member',
            'member_joined' => 'Member joined',
            'member_removed' => 'Member removed',
            'settings_updated' => 'Updated team settings',
            default => $this->action,
        };
    }

    public function getDeviceInfoAttribute(): ?string
    {
        $ua = $this->metadata['user_agent'] ?? null;
        if (!$ua) {
            return null;
        }

        $browser = 'Unknown Browser';
        $os = 'Unknown OS';

        // Detect browser
        if (str_contains($ua, 'Firefox')) {
            $browser = 'Firefox';
        } elseif (str_contains($ua, 'Edg/')) {
            $browser = 'Edge';
        } elseif (str_contains($ua, 'Chrome')) {
            $browser = 'Chrome';
        } elseif (str_contains($ua, 'Safari')) {
            $browser = 'Safari';
        } elseif (str_contains($ua, 'Opera') || str_contains($ua, 'OPR')) {
            $browser = 'Opera';
        }

        // Detect OS
        if (str_contains($ua, 'Windows')) {
            $os = 'Windows';
        } elseif (str_contains($ua, 'Mac OS')) {
            $os = 'macOS';
        } elseif (str_contains($ua, 'Linux')) {
            $os = 'Linux';
        } elseif (str_contains($ua, 'Android')) {
            $os = 'Android';
        } elseif (str_contains($ua, 'iPhone') || str_contains($ua, 'iPad')) {
            $os = 'iOS';
        }

        return "$browser on $os";
    }

    public static function log(Team $team, string $action, ?User $user = null, array $metadata = []): self
    {
        // Auto-capture request info
        $metadata['ip_address'] = request()->ip();
        $metadata['user_agent'] = request()->userAgent();

        return self::create([
            'team_id' => $team->id,
            'user_id' => $user?->id,
            'action' => $action,
            'metadata' => $metadata,
        ]);
    }
}
