<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminAuthController extends Controller
{
    /**
     * Display the admin login form.
     */
    public function showLoginForm()
    {
        return view('auth.admin.login');
    }

    /**
     * Handle admin login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Check if the user exists and is an admin
        $user = User::where('email', $credentials['email'])
                   ->where('user_type', 'admin')
                   ->first();

        if (!$user) {
            Log::warning('Admin login attempt with invalid email', [
                'email' => $credentials['email'],
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
            
            return back()->withErrors([
                'email' => 'Invalid administrator credentials.'
            ])->withInput($request->only('email'));
        }

        // Attempt to authenticate
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            Log::info('Admin login successful', [
                'user_id' => Auth::id(),
                'email' => Auth::user()->email,
                'ip' => $request->ip()
            ]);

            return redirect()->intended('/admin/dashboard');
        }

        Log::warning('Admin login failed - incorrect password', [
            'email' => $credentials['email'],
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return back()->withErrors([
            'email' => 'Invalid administrator credentials.'
        ])->withInput($request->only('email'));
    }

    /**
     * Display the admin registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.admin.register');
    }

    /**
     * Handle admin registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'admin_level' => ['required', 'string', 'in:super_admin,admin,moderator'],
            'department' => ['nullable', 'string', 'max:255'],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
            'security_acknowledge' => ['required', 'accepted'],
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type' => 'admin',
                'email_verified_at' => now(), // Auto-verify admin accounts
            ]);

            // Create admin profile with additional fields
            $user->adminProfile()->create([
                'admin_level' => $request->admin_level,
                'department' => $request->department,
                'admin_notes' => $request->admin_notes,
                'created_by' => Auth::id() ?? null, // Track who created this admin
                'status' => 'active',
            ]);

            Log::info('New admin account created', [
                'admin_id' => $user->id,
                'email' => $user->email,
                'admin_level' => $request->admin_level,
                'created_by' => Auth::id(),
                'ip' => $request->ip()
            ]);

            DB::commit();

            // Auto-login the new admin
            Auth::login($user);

            return redirect('/admin/dashboard')->with('success', 'Administrator account created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Admin registration failed', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);

            return back()->withErrors([
                'registration' => 'Account creation failed. Please try again.'
            ])->withInput($request->except('password', 'password_confirmation'));
        }
    }

    /**
     * Handle admin logout request
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        Log::info('Admin logout', [
            'admin_id' => $user->id,
            'email' => $user->email,
            'ip' => $request->ip()
        ]);

        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/admin/login')->with('status', 'Successfully logged out.');
    }
}