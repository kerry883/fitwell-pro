<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AdminActivityLogger;
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
        // If admin is already authenticated, redirect to dashboard
        if (Auth::guard('admin')->check()) {
            return redirect('/admin/dashboard');
        }
        
        // If user is authenticated with web guard but not admin, logout from web guard
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }
        
        return view('auth.admin.login');
    }

    /**
     * Handle admin login request.
     */
    public function login(Request $request)
    {
        // If admin is already authenticated, redirect to dashboard
        if (Auth::guard('admin')->check()) {
            return redirect('/admin/dashboard');
        }
        
        // If user is authenticated with web guard, logout from web guard
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Check if the user exists and is an admin
        $user = User::where('email', $credentials['email'])
            ->where('user_type', 'admin')
            ->first();

        if (!$user) {
            AdminActivityLogger::logFailedLogin(
                $credentials['email'],
                'Invalid email or user not found',
                $request
            );

            return back()->withErrors([
                'email' => 'Invalid administrator credentials.'
            ])->withInput($request->only('email'));
        }

        // Attempt to authenticate using admin guard
        if (Auth::guard('admin')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            // Invalidate and regenerate session to prevent session fixation
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Set admin-specific session variables
            $request->session()->put('admin_guard', true);
            $request->session()->put('admin_last_activity', now());

            AdminActivityLogger::logLogin(
                Auth::guard('admin')->id(),
                Auth::guard('admin')->user()->email,
                $request
            );

            return redirect()->intended('/admin/dashboard');
        }

        AdminActivityLogger::logFailedLogin(
            $credentials['email'],
            'Incorrect password',
            $request
        );

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

            AdminActivityLogger::logRegistration(
                $user->id,
                $user->email,
                $request->admin_level,
                Auth::id(),
                $request
            );

            DB::commit();

            // Auto-login the new admin with admin guard
            Auth::guard('admin')->login($user);

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
        $user = Auth::guard('admin')->user();
        
        if ($user) {
            AdminActivityLogger::logLogout(
                $user->id,
                $user->email,
                $request
            );
        }

        Auth::guard('admin')->logout();
        
        // Clear admin-specific session variables
        $request->session()->forget(['admin_guard', 'admin_last_activity']);
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'Successfully logged out.');
    }
}
