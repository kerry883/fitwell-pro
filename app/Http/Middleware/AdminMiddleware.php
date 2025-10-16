<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        \Log::info('AdminMiddleware: Checking authentication', [
            'url' => $request->url(),
            'admin_guard_check' => Auth::guard('admin')->check(),
            'web_guard_check' => Auth::guard('web')->check(),
        ]);
        
        // Check if user is authenticated with admin guard
        if (!Auth::guard('admin')->check()) {
            \Log::info('AdminMiddleware: Admin guard check failed, redirecting to login');
            return redirect()->route('admin.login');
        }

        $user = Auth::guard('admin')->user();
        
        \Log::info('AdminMiddleware: User authenticated', [
            'user_id' => $user ? $user->id : null,
            'user_type' => $user ? $user->user_type : null,
            'is_admin' => $user ? $user->isAdmin() : false,
        ]);
        
        // Ensure the user is actually an admin
        if (!$user || !$user->isAdmin()) {
            \Log::info('AdminMiddleware: User is not admin, logging out');
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Unauthorized access. Admin privileges required.'
            ]);
        }

        \Log::info('AdminMiddleware: Access granted');
        return $next($request);
    }
}
