<?php

namespace App\Http\Middleware;

use App\Services\AdminActivityLogger;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddlewareNew
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Set admin guard for the duration of this request
        config(['auth.defaults.guard' => 'admin']);

        \Log::info('AdminMiddleware: Checking authentication', [
            'url' => $request->url(),
            'admin_guard_check' => Auth::guard('admin')->check(),
            'web_guard_check' => Auth::guard('web')->check(),
            'session_id' => session()->getId(),
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

        // Verify admin has proper privileges
        if (!$user || !$user->hasAdminPrivileges()) {
            \Log::warning('AdminMiddleware: User lacks admin privileges', [
                'user_id' => $user ? $user->id : null,
                'user_type' => $user ? $user->user_type : null,
                'admin_profile_status' => $user && $user->adminProfile ? $user->adminProfile->status : 'none',
            ]);
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Access denied. Admin privileges required or account is inactive.'
            ]);
        }

        \Log::info('AdminMiddleware: Access granted to admin', [
            'admin_id' => $user->id,
            'admin_level' => $user->adminProfile->admin_level ?? 'unknown',
        ]);
        
        // Log route access
        AdminActivityLogger::logRouteAccess(
            $request->route()->getName() ?? 'unnamed',
            [
                'admin_level' => $user->adminProfile->admin_level,
            ],
            $request
        );

        return $next($request);
    }
}
