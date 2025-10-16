<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Account - FitWell Pro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- CSRF Token Meta Tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --primary: #28a745;
            --primary-dark: #1e7e34;
            --secondary: #17a2b8;
            --gradient-primary: linear-gradient(135deg, var(--primary), var(--secondary));
        }
    </style>
</head>
<body class="font-['Figtree'] bg-gray-50 min-h-screen antialiased">
    <!-- Header -->
    <header class="bg-white shadow-sm backdrop-blur-sm bg-white/95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center">
                    <div class="h-8 w-8 bg-gradient-to-r from-[#28a745] to-[#17a2b8] rounded-lg flex items-center justify-center">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 text-xl font-bold text-gray-900">FitWell Pro</span>
                </a>
                <div class="text-sm text-gray-600 hidden sm:block">
                    Need help?
                    <a href="mailto:support@fitwellpro.com" class="font-medium text-[#28a745] hover:text-[#1e7e34] transition-colors">Contact Support</a>
                </div>
            </div>
        </div>
    </header>

    <div class="min-h-screen py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <div class="mx-auto w-16 h-16 bg-gradient-to-r from-[#28a745] to-[#17a2b8] rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Verify Your Email</h2>
                <p class="mt-2 text-gray-600">We've sent a verification code to <strong>{{ $user->email }}</strong></p>
                <span class="inline-block mt-3 px-3 py-1 text-xs font-semibold text-{{ $user->user_type === 'client' ? 'green' : 'blue' }}-700 bg-{{ $user->user_type === 'client' ? 'green' : 'blue' }}-100 rounded-full">
                    {{ ucfirst($user->user_type) }} Account
                </span>
            </div>

            <div class="bg-white shadow-xl rounded-xl border border-gray-100 overflow-hidden backdrop-blur-sm bg-white/95">
                <!-- OTP Verification Form -->
                <div x-data="otpForm()" x-init="init()">
                <form action="{{ route('verify.otp') }}" method="POST" class="p-8" @submit="loading = true">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    
                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex">
                                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Verification Error</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Success Messages -->
                    <div x-show="$store.alert && $store.alert.type === 'success'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-90"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800" x-text="$store.alert.message"></p>
                            </div>
                        </div>
                    </div>

                    <!-- OTP Input Fields -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-4 text-center">
                                Enter the 6-digit verification code
                            </label>
                            
                            <div class="flex justify-center space-x-3 mb-4">
                                <template x-for="(digit, index) in otpDigits" :key="index">
                                    <input 
                                        type="text" 
                                        :id="'otp-' + index"
                                        maxlength="1" 
                                        class="w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                                        x-model="otpDigits[index]"
                                        @input="handleInput($event, index)"
                                        @keydown.backspace="handleBackspace($event, index)"
                                        @paste="handlePaste($event)"
                                    >
                                </template>
                            </div>
                            
                            <input type="hidden" name="otp_code" id="otp_code">
                            
                            @error('otp_code')
                                <p class="mt-1 text-sm text-red-600 text-center">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Verify Button -->
                        <div>
                            <button
                                type="submit"
                                :disabled="loading || otpDigits.join('').length !== 6"
                                class="w-full bg-gradient-to-r from-[#28a745] to-[#17a2b8] text-white py-3 rounded-lg font-semibold hover:shadow-lg transition duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                            >
                                <span x-show="!loading">Verify Account</span>
                                <span x-show="loading" class="flex items-center justify-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Verifying...
                                </span>
                            </button>
                        </div>

                        <!-- Resend Code -->
                        <div class="text-center">
                            <p class="text-sm text-gray-600 mb-3">Didn't receive the code?</p>
                            <button
                                type="button"
                                @click="sendOtp()"
                                :disabled="!canResend || resendLoading"
                                class="text-[#28a745] hover:text-[#1e7e34] font-medium text-sm transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <span x-show="!resendLoading && canResend">Resend Code</span>
                                <span x-show="!canResend && cooldown > 0">
                                    Resend in <span x-text="cooldown"></span>s
                                </span>
                                <span x-show="resendLoading" class="flex items-center justify-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-[#28a745]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Sending...
                                </span>
                            </button>
                        </div>

                        <!-- Help Text -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex">
                                <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Verification Tips</h3>
                                    <div class="mt-1 text-sm text-blue-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            <li>Check your email inbox and spam folder</li>
                                            <li>The code expires in 10 minutes</li>
                                            <li>You can request a new code every 30 seconds</li>
                                            @if($user->user_type === 'trainer')
                                                <li>Trainer accounts require admin approval after verification</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>

            <!-- Additional Help -->
            <div class="text-center mt-8">
                <p class="text-sm text-gray-600">
                    Having trouble? 
                    <a href="mailto:support@fitwellpro.com" class="font-medium text-[#28a745] hover:text-[#1e7e34] transition-colors">
                        Contact our support team
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Alpine.js global data store for alerts
        document.addEventListener('alpine:init', () => {
            Alpine.store('alert', {
                type: null,
                message: null,
                show: false,
                
                success(message) {
                    this.type = 'success';
                    this.message = message;
                    this.show = true;
                    setTimeout(() => this.hide(), 5000);
                },
                
                error(message) {
                    this.type = 'error';
                    this.message = message;
                    this.show = true;
                    setTimeout(() => this.hide(), 5000);
                },
                
                hide() {
                    this.show = false;
                    this.type = null;
                    this.message = null;
                }
            });
        });

        // OTP Form Component
        function otpForm() {
            return {
                loading: false, 
                otpDigits: ['', '', '', '', '', ''],
                cooldown: 0,
                canResend: true,
                resendLoading: false,
                
                init() {
                    // Auto-send OTP on page load
                    setTimeout(() => this.sendOtp(), 100);
                    
                    // Watch cooldown changes
                    this.$watch('cooldown', (value) => {
                        if (value > 0) {
                            this.canResend = false;
                            const timer = setInterval(() => {
                                this.cooldown--;
                                if (this.cooldown <= 0) {
                                    clearInterval(timer);
                                    this.canResend = true;
                                }
                            }, 1000);
                        }
                    });
                },
                
                sendOtp() {
                    this.resendLoading = true;
                    
                    fetch('{{ route("send.otp") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            user_id: {{ $user->id }}
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.resendLoading = false;
                        
                        if (data.success) {
                            Alpine.store('alert').success(data.message);
                            this.cooldown = data.cooldown || 30;
                        } else {
                            Alpine.store('alert').error(data.message);
                            if (data.cooldown) {
                                this.cooldown = data.cooldown;
                            }
                        }
                    })
                    .catch(error => {
                        this.resendLoading = false;
                        Alpine.store('alert').error('Failed to send verification code. Please try again.');
                        console.error('Error:', error);
                    });
                },
                
                handleInput(event, index) {
                    // Move to next input
                    if (event.target.value && index < 5) {
                        document.getElementById('otp-' + (index + 1)).focus();
                    }
                    // Update hidden field
                    document.getElementById('otp_code').value = this.otpDigits.join('');
                },
                
                handleBackspace(event, index) {
                    // Move to previous input on backspace
                    if (!event.target.value && index > 0) {
                        document.getElementById('otp-' + (index - 1)).focus();
                    }
                },
                
                handlePaste(event) {
                    event.preventDefault();
                    const pastedData = event.clipboardData.getData('text').slice(0, 6);
                    if (/^\d{6}$/.test(pastedData)) {
                        for (let i = 0; i < 6; i++) {
                            this.otpDigits[i] = pastedData[i] || '';
                        }
                        document.getElementById('otp_code').value = pastedData;
                    }
                }
            }
        }


    </script>

</body>
</html>