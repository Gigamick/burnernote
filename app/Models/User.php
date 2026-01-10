<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'last_login_at',
        'profile_completed',
        'account_mode',
        'default_max_expiry_days',
        'default_min_expiry_days',
        'default_require_password',
        'default_max_view_limit',
        'burn_me_slug',
        'burn_me_enabled',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'profile_completed' => 'boolean',
        'default_require_password' => 'boolean',
        'burn_me_enabled' => 'boolean',
    ];

    public function getFullNameAttribute(): string
    {
        if ($this->first_name && $this->last_name) {
            return "{$this->first_name} {$this->last_name}";
        }
        return $this->email;
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_members')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function ownedTeams(): HasMany
    {
        return $this->hasMany(Team::class, 'owner_id');
    }

    public function hasPro(): bool
    {
        return $this->account_mode === 'individual' || $this->teams()->exists();
    }

    public function isIndividual(): bool
    {
        return $this->account_mode === 'individual';
    }

    public function getDefaults(): array
    {
        return [
            'max_expiry_days' => $this->default_max_expiry_days,
            'min_expiry_days' => $this->default_min_expiry_days,
            'require_password' => $this->default_require_password,
            'max_view_limit' => $this->default_max_view_limit,
        ];
    }

    public function burnMeNotes(): HasMany
    {
        return $this->hasMany(Note::class, 'recipient_user_id')
            ->where('is_burn_me', true)
            ->orderBy('created_at', 'desc');
    }

    public function unreadBurnMeNotes(): HasMany
    {
        return $this->burnMeNotes()->whereNull('read_at');
    }

    public function getBurnMeUrlAttribute(): ?string
    {
        return $this->burn_me_slug
            ? config('app.url') . '/b/' . $this->burn_me_slug
            : null;
    }
}
