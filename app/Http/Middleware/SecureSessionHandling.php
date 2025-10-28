<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SecureSessionHandling
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Clean up expired sessions before processing request
        $this->cleanupExpiredSessions();
        
        // Prevent session fixation on authentication state changes
        if ($request->user() && !$request->session()->has('auth_regenerated')) {
            Log::info('Regenerating session for authenticated user', [
                'user_id' => $request->user()->id,
                'user_type' => $request->user()->user_type,
                'session_id' => $request->session()->getId(),
            ]);
            $request->session()->regenerate();
            $request->session()->put('auth_regenerated', true);
            Log::info('Session regenerated successfully', [
                'new_session_id' => $request->session()->getId(),
            ]);
        }
        
        return $next($request);
    }
    
    /**
     * Clean up expired sessions from database
     */
    protected function cleanupExpiredSessions(): void
    {
        $expiry = now()->subMinutes(config('session.lifetime'))->timestamp;
        DB::table('sessions')->where('last_activity', '<', $expiry)->delete();
    }
}