<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Receipt;
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
        $totalNotes = Receipt::count();

        // Users with their teams and note counts
        $users = User::withCount(['ownedTeams'])
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($user) {
                $user->team = $user->teams()->first();
                $user->notes_count = Receipt::where('team_id', $user->team?->id)->count();
                return $user;
            });

        return view('admin.dashboard', compact('totalAccounts', 'totalNotes', 'users'));
    }
}
