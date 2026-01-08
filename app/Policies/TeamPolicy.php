<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;

class TeamPolicy
{
    public function view(User $user, Team $team): bool
    {
        return $team->isMember($user);
    }

    public function update(User $user, Team $team): bool
    {
        return $team->isAdmin($user);
    }

    public function manageMembers(User $user, Team $team): bool
    {
        return $team->isAdmin($user);
    }

    public function delete(User $user, Team $team): bool
    {
        return $team->isOwner($user);
    }
}
