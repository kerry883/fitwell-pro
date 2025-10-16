<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerificationMail;
use App\Models\User;
use App\Models\UserVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OtpVerificationController extends Controller
{
    /**
     * Show the OTP verification form
     */
    public function showVerificationForm(Request $request)
    {
        $userId = $request->get('user_id');
        $email = $request->get('email');
        
        if (!$userId || !$email) {
            return redirect()->route('register')->withErrors([
                'verification' => 'Invalid verification request. Please register again.'
            ]);
        }

        $user = User::find($userId);
        if (!$user || $user->email !== $email) {
            return redirect()->route('register')->withErrors([
                'verification' => 'Invalid user data. Please register again.'
            ]);
        }

        // Check if user is already verified
        if ($user->email_verified_at) {
            Auth::login($user);
            return redirect()->route('dashboard')->with('success', 'Your account is already verified!');
        }

        // Check if user should have OTP verification (clients and trainers only)
        if ($user->user_type === 'admin') {
            $user->update(['email_verified_at' => now()]);
            Auth::login($user);
            return redirect()->route('admin.dashboard');
        }

        return view('auth.verify-otp', compact('user'));
    }

    /**
     * Send OTP to user's email
     */
    public function sendOtp(Request $request)
    {
        $userId = $request->input('user_id');
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }

        // Check if user can resend OTP (throttling)
        if (!UserVerification::canResend($user->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Please wait 30 seconds before requesting a new code.',
                'cooldown' => 30
            ], 429);
        }

        try {
            // Invalidate any existing OTP codes for this user
            UserVerification::where('user_id', $user->id)->delete();

            // Generate new OTP
            $otpCode = UserVerification::generateOtp();
            
            // Store OTP in database
            UserVerification::create([
                'user_id' => $user->id,
                'otp_code' => $otpCode,
                'expires_at' => now()->addMinutes(10), // 10 minutes expiry
            ]);

            // Send email
            Mail::to($user->email)->send(new OtpVerificationMail($user, $otpCode));

            // Set resend throttle
            UserVerification::setResendThrottle($user->id, 30);

            Log::info('OTP sent successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Verification code sent to your email address.',
                'cooldown' => 30
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send OTP', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send verification code. Please try again.'
            ], 500);
        }
    }

    /**
     * Verify the OTP code
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp_code' => 'required|string|size:6',
        ]);

        $user = User::find($request->user_id);
        $otpCode = $request->otp_code;

        // Find the latest OTP for this user
        $verification = UserVerification::where('user_id', $user->id)
            ->where('verified_at', null)
            ->latest()
            ->first();

        if (!$verification) {
            return back()->withErrors([
                'otp_code' => 'No verification code found. Please request a new code.'
            ]);
        }

        // Check if OTP is expired
        if ($verification->isExpired()) {
            return back()->withErrors([
                'otp_code' => 'Verification code has expired. Please request a new code.'
            ]);
        }

        // Check attempts limit
        if ($verification->attempts >= 3) {
            $verification->delete();
            return back()->withErrors([
                'otp_code' => 'Too many failed attempts. Please request a new verification code.'
            ]);
        }

        // Verify the OTP code
        if ($verification->otp_code !== $otpCode) {
            $verification->incrementAttempts();
            return back()->withErrors([
                'otp_code' => 'Invalid verification code. Please try again.'
            ])->withInput();
        }

        try {
            // Mark as verified
            $verification->markAsVerified();
            $user->update(['email_verified_at' => now()]);

            // Clean up old verification records
            UserVerification::where('user_id', $user->id)
                ->where('id', '!=', $verification->id)
                ->delete();

            Log::info('User email verified successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'user_type' => $user->user_type,
                'ip' => $request->ip()
            ]);

            // Log the user in
            Auth::login($user);

            $message = $user->user_type === 'trainer' 
                ? 'Account verified successfully! Your trainer profile is pending approval.'
                : 'Account verified successfully! Welcome to FitWell Pro.';

            return redirect()->route('dashboard')->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Failed to verify OTP', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);

            return back()->withErrors([
                'otp_code' => 'Verification failed. Please try again.'
            ]);
        }
    }
}
