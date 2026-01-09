<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamAuditLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        $teams = Auth::user()->teams()->withCount('members')->get();

        return view('teams.index', compact('teams'));
    }

    public function create(): View
    {
        return view('teams.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $team = Team::create([
            'name' => $validated['name'],
            'owner_id' => Auth::id(),
        ]);

        // Add owner as a member with owner role
        $team->members()->attach(Auth::id(), ['role' => 'owner']);

        // If onboarding, redirect to homepage with welcome message
        if ($request->boolean('onboarding')) {
            return redirect('/')->with('success', 'Welcome to Burner Note! Your team is ready.');
        }

        return redirect()->route('teams.show', $team)
            ->with('success', 'Team created successfully.');
    }

    public function show(Team $team): View
    {
        $this->authorize('view', $team);

        $team->load(['members', 'invitations' => function ($query) {
            $query->whereNull('accepted_at')->where('expires_at', '>', now());
        }]);

        return view('teams.show', compact('team'));
    }

    public function settings(Team $team): View
    {
        $this->authorize('update', $team);

        return view('teams.settings', compact('team'));
    }

    public function updateSettings(Request $request, Team $team): RedirectResponse
    {
        $this->authorize('update', $team);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'policy_max_expiry_days' => 'required|integer|min:1|max:365',
            'policy_min_expiry_days' => 'required|integer|min:1|max:365',
            'policy_max_view_limit' => 'required|integer|min:1|max:100',
        ]);

        // Handle checkbox separately
        $validated['policy_require_password'] = $request->boolean('policy_require_password');

        // Ensure min <= max
        if ($validated['policy_min_expiry_days'] > $validated['policy_max_expiry_days']) {
            return back()->withErrors(['policy_min_expiry_days' => 'Minimum expiry cannot exceed maximum expiry.']);
        }

        // Track what actually changed
        $changes = [];
        foreach ($validated as $key => $value) {
            if ($team->$key != $value) {
                $changes[$key] = [
                    'from' => $team->$key,
                    'to' => $value,
                ];
            }
        }

        $team->update($validated);

        // Only log if something actually changed
        if (!empty($changes)) {
            TeamAuditLog::log($team, 'settings_updated', Auth::user(), [
                'changes' => $changes,
            ]);
        }

        return redirect()->route('teams.settings', $team)
            ->with('success', 'Team settings updated.');
    }

    public function members(Team $team): View
    {
        $this->authorize('manageMembers', $team);

        $team->load(['members', 'invitations' => function ($query) {
            $query->whereNull('accepted_at')->where('expires_at', '>', now());
        }]);

        return view('teams.members', compact('team'));
    }

    public function clearAuditLog(Team $team): RedirectResponse
    {
        $this->authorize('delete', $team);

        $count = $team->auditLogs()->count();
        $team->auditLogs()->delete();

        return redirect()->route('teams.audit-log', $team)
            ->with('success', "Deleted {$count} audit log entries.");
    }

    public function auditLog(Team $team): View
    {
        $this->authorize('view', $team);

        // Get all logs
        $allLogs = $team->auditLogs()
            ->with('user')
            ->orderByDesc('created_at')
            ->get();

        // Group note-related logs by note_token
        $noteActions = ['note_created', 'note_viewed', 'note_expired'];
        $groupedLogs = collect();
        $processedNoteTokens = [];

        foreach ($allLogs as $log) {
            $noteToken = $log->metadata['note_token'] ?? null;

            // If this is a note action with a token
            if (in_array($log->action, $noteActions) && $noteToken) {
                // Skip if we've already processed this note
                if (in_array($noteToken, $processedNoteTokens)) {
                    continue;
                }

                // Find the note_created log for this token
                $createdLog = $allLogs->first(fn($l) =>
                    $l->action === 'note_created' &&
                    ($l->metadata['note_token'] ?? null) === $noteToken
                );

                if ($createdLog) {
                    // Find all child events for this note
                    $childLogs = $allLogs->filter(fn($l) =>
                        in_array($l->action, ['note_viewed', 'note_expired']) &&
                        ($l->metadata['note_token'] ?? null) === $noteToken
                    )->sortByDesc('created_at')->values();

                    $createdLog->children = $childLogs;
                    $groupedLogs->push($createdLog);
                    $processedNoteTokens[] = $noteToken;
                }
            } else {
                // Non-note action, add directly
                $log->children = collect();
                $groupedLogs->push($log);
            }
        }

        // Sort by created_at descending
        $logs = $groupedLogs->sortByDesc('created_at')->values();

        return view('teams.audit-log', compact('team', 'logs'));
    }
}
