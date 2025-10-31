<?php

namespace App\Mail;

use App\Models\User;
use App\Services\DevMailLogger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OtpVerificationMail extends Mailable
{
    use SerializesModels;

    public $user;
    public $otpCode;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $otpCode)
    {
        $this->user = $user;
        $this->otpCode = $otpCode;

        // Log email details in development
        try {
            if (app()->environment('local')) {
                DevMailLogger::logOtpEmail($user, $otpCode);
            }
        } catch (\Exception $e) {
            Log::error('Failed to log OTP email', [
                'error' => $e->getMessage(),
                'user' => $user->email,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = app()->environment('local')
            ? '[DEV] FitWell Pro - Your OTP Verification Code'
            : 'Verify Your FitWell Pro Account - OTP Code';

        return new Envelope(
            subject: $subject,
            from: new \Illuminate\Mail\Mailables\Address(
                config('mail.from.address'),
                config('mail.from.name')
            )
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.otp-verification',
            with: [
                'user' => $this->user,
                'otpCode' => $this->otpCode,
                'isDevelopment' => app()->environment('local'),
            ]
        );
    }

    /**
     * Handle a failed sending attempt.
     */
    public function failed(\Throwable $exception): void
    {
        DevMailLogger::logDeliveryStatus($this->user, 'failed', $exception->getMessage());
    }

    /**
     * Handle a successful sending attempt.
     */
    public function sent(): void
    {
        DevMailLogger::logDeliveryStatus($this->user, 'sent');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
