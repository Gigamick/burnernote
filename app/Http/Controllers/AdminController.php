<?php

namespace App\Http\Controllers;

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

        // Get note counts per user from receipts (tracks all notes, free + Pro)
        $noteCounts = Receipt::whereNotNull('user_id')
            ->selectRaw('user_id, count(*) as count')
            ->groupBy('user_id')
            ->pluck('count', 'user_id');

        // Users with their teams and note counts
        $users = User::orderByDesc('created_at')
            ->get()
            ->map(function ($user) use ($noteCounts) {
                $user->team = $user->teams()->first();
                $user->notes_count = $noteCounts[$user->id] ?? 0;
                return $user;
            });

        return view('admin.dashboard', compact('totalAccounts', 'totalNotes', 'users'));
    }
}
