<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Mail\OtpVerificationMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestOtpEmail extends Command
{
    protected $signature = 'test:otp-email 
                            {email? : The email address to send the test to}
                            {--preview : Preview the email in the browser instead of sending}';

    protected $description = 'Test the OTP verification email template';

    public function handle()
    {
        if (!app()->environment('local')) {
            $this->error('This command can only be run in the local environment!');
            return 1;
        }

        // Create a test user
        $user = new User([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => $this->argument('email') ?? 'test@example.com',
            'user_type' => 'client'
        ]);

        $otpCode = '123456';
        $mail = new OtpVerificationMail($user, $otpCode);

        if ($this->option('preview')) {
            // Generate a temporary file with the rendered email
            $tempFile = storage_path('app/temp-mail-preview.html');
            file_put_contents($tempFile, $mail->render());
            
            // Open in browser
            $this->info('Opening email preview in browser...');
            if (PHP_OS_FAMILY === 'Windows') {
                exec('start ' . $tempFile);
            } elseif (PHP_OS_FAMILY === 'Darwin') {
                exec('open ' . $tempFile);
            } else {
                exec('xdg-open ' . $tempFile);
            }
            
            $this->info('Preview file saved to: ' . $tempFile);
            return 0;
        }

        // Send the test email
        $email = $this->argument('email') ?? $this->ask('Enter the email address to send the test to:');
        
        $this->info('Sending test OTP email to ' . $email);
        $user->email = $email;
        
        try {
            Mail::to($email)->send($mail);
            $this->info('Test email sent successfully!');
            $this->info('Check your Mailtrap inbox: ' . config('otp.dev_email.mailtrap_inbox'));
        } catch (\Exception $e) {
            $this->error('Failed to send test email: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}