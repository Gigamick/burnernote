<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOnboardingComplete
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->profile_completed && $user->account_mode === null) {
            // Auto-set existing users with teams to 'team' mode
            if ($user->teams()->exists()) {
                $user->update(['account_mode' => 'team']);
                return $next($request);
            }

            // Allow access to choose-mode and logout routes only
            if (!$request->routeIs('auth.choose-mode', 'auth.choose-mode.store', 'logout')) {
                return redirect()->route('auth.choose-mode');
            }
        }

        return $next($request);
    }
}
