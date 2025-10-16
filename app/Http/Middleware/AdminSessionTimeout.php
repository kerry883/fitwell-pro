<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class AdminSessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated with admin guard
        if (!Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Get the last activity time from session
        $lastActivity = $request->session()->get('admin_last_activity');

        // If no last activity recorded, set it to now
        if (!$lastActivity) {
            $request->session()->put('admin_last_activity', now());
            return $next($request);
        }

        // Parse the last activity time
        $lastActivityTime = Carbon::parse($lastActivity);

        // Check if session has expired (30 minutes of inactivity)
        $timeoutMinutes = 30;
        $now = Carbon::now();

        if ($now->diffInMinutes($lastActivityTime) > $timeoutMinutes) {
            // Session has expired, log out the user
            Auth::guard('admin')->logout();

            // Clear admin-specific session variables
            $request->session()->forget(['admin_guard', 'admin_last_activity']);

            // Invalidate and regenerate session
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')
                ->with('status', 'Your session has expired due to inactivity. Please log in again.')
                ->with('warning', true);
        }

        // Update last activity time
        $request->session()->put('admin_last_activity', now());

        return $next($request);
    }
}
