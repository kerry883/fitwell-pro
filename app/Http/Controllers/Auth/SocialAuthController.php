<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect to social provider
     */
    public function redirect($provider)
    {
        $validProviders = ['google', 'facebook']; // Removed GitHub
        
        if (!in_array($provider, $validProviders)) {
            return redirect('/login')->withErrors(['error' => 'Invalid social provider']);
        }

        try {
            return Socialite::driver($provider)->redirect();
        } catch (\Exception $e) {
            \Log::error("Social redirect failed for {$provider}", [
                'error' => $e->getMessage(),
                'provider' => $provider
            ]);
            
            return redirect('/login')->withErrors(['error' => 'Social login is temporarily unavailable. Please try email login.']);
        }
    }

    /**
     * Handle social provider callback
     */
    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            
            // Validate we have required data
            if (!$socialUser->getEmail()) {
                return redirect('/login')->withErrors(['error' => 'Email is required for registration. Please ensure your social account has a public email.']);
            }
            
            // Check if user already exists with this provider
            $user = User::where('provider_id', $socialUser->getId())
                       ->where('provider_name', $provider)
                       ->first();

            if ($user) {
                // Update user info from social provider
                $user->update([
                    'profile_picture' => $socialUser->getAvatar(),
                    'provider_token' => $socialUser->token,
                ]);
                
                Auth::login($user);
                
                // Check if profile completion is needed
                if ($user->needs_profile_completion) {
                    return redirect()->route('profile.complete');
                }
                
                return redirect()->intended('/dashboard');
            }

            // Check if user exists with same email
            $existingUser = User::where('email', $socialUser->getEmail())->first();
            
            if ($existingUser) {
                // Prevent linking admin accounts to social providers
                if ($existingUser->user_type === 'admin') {
                    return redirect('/login')->withErrors(['error' => 'Administrator accounts cannot be linked to social providers.']);
                }
                
                // Link social account to existing user
                $existingUser->update([
                    'provider_id' => $socialUser->getId(),
                    'provider_name' => $provider,
                    'profile_picture' => $socialUser->getAvatar(),
                    'provider_token' => $socialUser->token,
                    'email_verified_at' => now(), // Social accounts are considered verified
                ]);
                
                Auth::login($existingUser);
                return redirect()->intended('/dashboard');
            }

            // Parse name from social provider
            $nameParts = explode(' ', $socialUser->getName() ?? '', 2);
            $firstName = $nameParts[0] ?? 'User';
            $lastName = $nameParts[1] ?? '';

            // Create new user
            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $socialUser->getEmail(),
                'provider_id' => $socialUser->getId(),
                'provider_name' => $provider,
                'provider_token' => $socialUser->token,
                'profile_picture' => $socialUser->getAvatar(),
                'user_type' => 'client', // Default to client, will be asked to complete profile
                'needs_profile_completion' => true,
                'email_verified_at' => now(), // Social accounts are considered verified
            ]);

            // Log social registration
            \Log::info('Social registration successful', [
                'user_id' => $user->id,
                'email' => $user->email,
                'provider' => $provider,
            ]);

            Auth::login($user);
            
            // Redirect to profile completion
            return redirect()->route('profile.complete')->with('info', 'Please complete your profile to get started.');
            
        } catch (\Exception $e) {
            \Log::error("Social callback failed for {$provider}", [
                'error' => $e->getMessage(),
                'provider' => $provider
            ]);
            
            return redirect('/login')->withErrors(['error' => 'Social login failed. Please try again or use email login.']);
        }
    }
}
