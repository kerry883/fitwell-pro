<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your FitWell Pro Account</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #28a745, #17a2b8);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header .logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            margin-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            color: #374151;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .message {
            color: #6b7280;
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.5;
        }
        .otp-container {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border: 2px dashed #28a745;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
        }
        .otp-label {
            color: #6b7280;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .otp-code {
            font-size: 36px;
            font-weight: 800;
            color: #28a745;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            margin: 15px 0;
            text-align: center;
            background: #ffffff;
            padding: 15px 30px;
            border-radius: 8px;
            display: inline-block;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .otp-note {
            color: #dc3545;
            font-size: 14px;
            font-weight: 600;
            margin-top: 15px;
        }
        .instructions {
            background-color: #f8f9fa;
            border-left: 4px solid #17a2b8;
            padding: 20px;
            border-radius: 0 8px 8px 0;
            margin: 30px 0;
        }
        .instructions h3 {
            color: #374151;
            margin: 0 0 15px 0;
            font-size: 16px;
            font-weight: 600;
        }
        .instructions ol {
            color: #6b7280;
            margin: 0;
            padding-left: 20px;
        }
        .instructions li {
            margin-bottom: 8px;
        }
        .warning {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
        }
        .warning h3 {
            color: #dc2626;
            margin: 0 0 10px 0;
            font-size: 16px;
            font-weight: 600;
        }
        .warning p {
            color: #7f1d1d;
            margin: 0;
            font-size: 14px;
        }
        .footer {
            background-color: #f8f9fa;
            color: #6b7280;
            text-align: center;
            padding: 30px;
            font-size: 14px;
            border-top: 1px solid #e5e7eb;
        }
        .footer a {
            color: #28a745;
            text-decoration: none;
        }
        .support {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }
        .user-type-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-left: 10px;
        }
        .badge-client {
            background-color: #dcfdf7;
            color: #059669;
        }
        .badge-trainer {
            background-color: #dbeafe;
            color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h1>FitWell Pro</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Hello {{ $user->first_name }}!
                <span class="user-type-badge {{ $user->user_type === 'client' ? 'badge-client' : 'badge-trainer' }}">
                    {{ ucfirst($user->user_type) }}
                </span>
            </div>

            <div class="message">
                Welcome to FitWell Pro! We're excited to have you join our fitness community. To complete your account setup and ensure the security of your account, please verify your email address using the verification code below.
            </div>

            <!-- OTP Code -->
            <div class="otp-container">
                <div class="otp-label">Your Verification Code</div>
                <div class="otp-code">{{ $otpCode }}</div>
                <div class="otp-note">⏰ This code will expire in 10 minutes</div>
            </div>

            <!-- Instructions -->
            <div class="instructions">
                <h3>📋 How to verify your account:</h3>
                <ol>
                    <li>Return to the FitWell Pro verification page</li>
                    <li>Enter the 6-digit code shown above</li>
                    <li>Click "Verify Account" to complete the process</li>
                    <li>Start your fitness journey!</li>
                </ol>
            </div>

            @if($user->user_type === 'trainer')
            <div class="warning">
                <h3>🎓 Trainer Account Notice</h3>
                <p>As a personal trainer, your account will undergo a review process after verification. You'll receive an email notification once your trainer profile is approved and you can start accepting clients.</p>
            </div>
            @endif

            <!-- Security Warning -->
            <div class="warning">
                <h3>🔐 Security Notice</h3>
                <p>Never share this verification code with anyone. FitWell Pro staff will never ask for your verification code via email, phone, or any other communication method.</p>
            </div>

            <div class="message">
                If you didn't create an account with FitWell Pro, please ignore this email or contact our support team if you have concerns.
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                <strong>FitWell Pro</strong><br>
                Your Partner in Fitness Excellence
            </p>
            
            <div class="support">
                Need help? Contact our support team at 
                <a href="mailto:support@fitwellpro.com">support@fitwellpro.com</a>
                <br><br>
                This email was sent to {{ $user->email }}
                <br>
                © {{ date('Y') }} FitWell Pro. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>