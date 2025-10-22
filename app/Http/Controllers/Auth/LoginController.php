<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {


        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Rate limiting: max 5 attempts per minute
        $key = 'login_attempts_' . $request->ip();
        $maxAttempts = 5;
        $decayMinutes = 1;

        if (cache()->has($key) && cache($key) >= $maxAttempts) {
            throw ValidationException::withMessages([
                'email' => ['Too many login attempts. Please try again in 1 minute.'],
            ]);
        }

        // Prevent admin accounts from logging in through regular login
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        if ($user && $user->user_type === 'admin') {
            throw ValidationException::withMessages([
                'email' => ['Administrator accounts must use the admin login portal.'],
            ]);
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // Clear rate limiting on successful login
            cache()->forget($key);
            
            // Check if profile completion is needed (for social login users)
            if (Auth::user()->needs_profile_completion) {
                return redirect()->route('profile.complete');
            }
            
            // Role-based redirect
            $user = Auth::user();
            if ($user->isTrainer()) {
                return redirect()->intended(route('trainer.dashboard'));
            } elseif ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            } else {
                return redirect()->intended('/dashboard');
            }
        }

        // Increment rate limiting counter
        $attempts = cache()->get($key, 0) + 1;
        cache()->put($key, $attempts, now()->addMinutes($decayMinutes));

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // Let Laravel handle session invalidation and token regeneration.
        
        return redirect('/')
            ->withHeaders([
                'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => 'Fri, 01 Jan 1990 00:00:00 GMT'
            ]);
    }
}
