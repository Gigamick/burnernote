<?php

namespace App\Http\Controllers;

use App\Mail\TeamInvitationMail;
use App\Models\Team;
use App\Models\TeamAuditLog;
use App\Models\TeamInvitation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    public function invite(Request $request, Team $team): RedirectResponse
    {
        $this->authorize('manageMembers', $team);

        $validated = $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:admin,member',
        ]);

        // Check if already a member
        if ($team->members()->where('email', $validated['email'])->exists()) {
            return back()->with('error', 'This person is already a team member.');
        }

        // Check if already invited
        if ($team->invitations()->where('email', $validated['email'])->whereNull('accepted_at')->where('expires_at', '>', now())->exists()) {
            return back()->with('error', 'An invitation has already been sent to this email.');
        }

        $invitation = TeamInvitation::create([
            'team_id' => $team->id,
            'email' => $validated['email'],
            'token' => Str::random(64),
            'role' => $validated['role'],
            'invited_by' => Auth::id(),
            'expires_at' => now()->addDays(7),
        ]);

        Mail::to($validated['email'])->send(new TeamInvitationMail($invitation));

        TeamAuditLog::log($team, 'member_invited', Auth::user(), [
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        return back()->with('success', 'Invitation sent to ' . $validated['email']);
    }

    public function acceptInvitation(string $token): RedirectResponse|View
    {
        $invitation = TeamInvitation::where('token', $token)->first();

        if (!$invitation || !$invitation->isValid()) {
            return view('teams.invitation-invalid');
        }

        // Find or create user - the invitation token proves they own this email
        $user = User::firstOrCreate(
            ['email' => $invitation->email],
            ['name' => explode('@', $invitation->email)[0]]
        );

        // Add user to team
        $invitation->team->members()->attach($user->id, ['role' => $invitation->role]);
        $invitation->update(['accepted_at' => now()]);

        TeamAuditLog::log($invitation->team, 'member_joined', $user, [
            'email' => $user->email,
            'role' => $invitation->role,
        ]);

        // Log them in
        Auth::login($user);
        $user->update(['last_login_at' => now()]);

        return redirect()->route('teams.show', $invitation->team)
            ->with('success', 'You have joined ' . $invitation->team->name);
    }

    public function remove(Team $team, User $member): RedirectResponse
    {
        $this->authorize('manageMembers', $team);

        // Cannot remove the owner
        if ($team->isOwner($member)) {
            return back()->with('error', 'Cannot remove the team owner.');
        }

        $team->members()->detach($member->id);

        TeamAuditLog::log($team, 'member_removed', Auth::user(), [
            'email' => $member->email,
        ]);

        return back()->with('success', 'Member removed from team.');
    }

    public function cancelInvitation(Team $team, TeamInvitation $invitation): RedirectResponse
    {
        $this->authorize('manageMembers', $team);

        if ($invitation->team_id !== $team->id) {
            abort(404);
        }

        $invitation->delete();

        return back()->with('success', 'Invitation cancelled.');
    }
}
