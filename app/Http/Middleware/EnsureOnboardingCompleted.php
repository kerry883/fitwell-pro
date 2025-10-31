<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureOnboardingCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // Only apply to authenticated users
        if (!$user) {
            return $next($request);
        }
        
        // Only apply to clients
        if ($user->user_type !== 'client') {
            return $next($request);
        }
        
        $client = $user->clientProfile;
        
        // Check if client profile exists
        if (!$client) {
            return $next($request);
        }
        
        // Check if onboarding is completed
        if (!$client->hasCompletedOnboarding()) {
            // Don't redirect if already on onboarding routes
            if (!$request->routeIs('client.onboarding.*')) {
                return redirect()->route('client.onboarding.start')
                    ->with('warning', 'Please complete your profile setup to continue.');
            }
        }
        
        return $next($request);
    }
}
