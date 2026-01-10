<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function dashboard(): View|Response
    {
        // Check if user is admin
        $adminEmail = env('ADMIN_EMAIL');
        if (!Auth::check() || Auth::user()->email !== $adminEmail) {
            abort(404);
        }

        // Stats
        $totalAccounts = User::count();
        $totalTeams = Team::count();
        $personalAccounts = User::where('individual_mode', true)->count();
        $totalNotes = Receipt::count();

        // Get note counts per team from receipts
        $teamNoteCounts = Receipt::whereNotNull('team_id')
            ->selectRaw('team_id, count(*) as count')
            ->groupBy('team_id')
            ->pluck('count', 'team_id');

        // Teams with their note counts and member counts
        $teams = Team::withCount('members')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($team) use ($teamNoteCounts) {
                $team->notes_count = $teamNoteCounts[$team->id] ?? 0;
                return $team;
            });

        return view('admin.dashboard', compact('totalAccounts', 'totalTeams', 'personalAccounts', 'totalNotes', 'teams'));
    }
}
