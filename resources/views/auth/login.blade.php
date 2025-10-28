<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - FitWell Pro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-inter bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center">
                    <div class="h-8 w-8 bg-gradient-to-r from-green-600 to-teal-600 rounded-lg flex items-center justify-center">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 text-xl font-bold text-gray-900">FitWell Pro</span>
                </a>
                <div class="text-sm text-gray-600 hidden sm:block">
                    New to FitWell Pro?
                    <a href="{{ route('register') }}" class="font-medium text-green-600 hover:text-green-500">Create an account</a>
                </div>
            </div>
        </div>
    </header>

    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Left Side - Form -->
        <div class="flex-1 flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8 lg:py-12">
            <div class="max-w-md w-full space-y-6 lg:space-y-8">
                <div class="text-center lg:text-left">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Welcome back</h2>
                    <p class="mt-2 text-gray-600 text-sm sm:text-base">Sign in to your FitWell Pro account</p>
                </div>

                <div class="bg-white py-6 sm:py-8 px-4 sm:px-6 shadow-xl rounded-xl border border-gray-100">
                    <form class="space-y-4 sm:space-y-6" action="{{ route('login') }}" method="POST" id="loginForm">
                        @csrf

                        <!-- Error Messages -->
                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3 sm:p-4">
                                <div class="flex">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Authentication Error</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            @foreach ($errors->all() as $error)
                                                <p>{{ $error }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="space-y-3 sm:space-y-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    autocomplete="email"
                                    required
                                    class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 text-sm sm:text-base"
                                    placeholder="Enter your email"
                                    value="{{ old('email') }}"
                                >
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    autocomplete="current-password"
                                    required
                                    class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 text-sm sm:text-base"
                                    placeholder="Enter your password"
                                >
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0">
                            <div class="flex items-center">
                                <input
                                    id="remember"
                                    name="remember"
                                    type="checkbox"
                                    class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                                >
                                <label for="remember" class="ml-2 block text-sm text-gray-700">
                                    Remember me
                                </label>
                            </div>
                            <a href="#" class="text-sm font-medium text-green-600 hover:text-green-500">
                                Forgot password?
                            </a>
                        </div>

                        <div>
                            <button
                                type="submit"
                                class="w-full bg-gradient-to-r from-green-600 to-teal-600 text-white py-2 sm:py-3 px-4 rounded-lg font-semibold hover:shadow-lg transition duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed text-sm sm:text-base"
                                id="loginButton"
                            >
                                <span id="signInText" class="flex items-center justify-center">
                                    Sign In
                                    <svg class="ml-2 h-3 w-3 sm:h-4 sm:w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </span>
                                <span id="signingInText" class="hidden items-center justify-center">
                                    <svg class="animate-spin h-4 w-4 sm:h-5 sm:w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span class="ml-2 text-sm sm:text-base">Signing in...</span>
                                </span>
                            </button>
                        </div>

                        <!-- Social Login -->
                        <div class="mt-4 sm:mt-6">
                            <div class="relative">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-4 bg-white text-gray-500 font-medium">Or continue with</span>
                                </div>
                            </div>

                            <div class="mt-4 sm:mt-6 grid grid-cols-2 gap-2 sm:gap-3">
                                <a href="{{ route('social.redirect', 'google') }}" class="w-full inline-flex justify-center items-center py-2 sm:py-3 px-3 sm:px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-xs sm:text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-200">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24">
                                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                    </svg>
                                    <span class="ml-2">Google</span>
                                </a>

                                <a href="{{ route('social.redirect', 'facebook') }}" class="w-full inline-flex justify-center items-center py-2 sm:py-3 px-3 sm:px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-xs sm:text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-200">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="#1877F2" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                    <span class="ml-2">Facebook</span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <p class="text-center text-xs sm:text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-medium text-green-600 hover:text-green-500">Sign up for free</a>
                </p>
            </div>
        </div>

        <!-- Right Side - Brand/Hero with Background Image -->
        <div class="hidden lg:flex lg:flex-1 relative overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                 style="background-image: url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');">
            </div>
            <!-- Overlay -->
            <div class="absolute inset-0 bg-gradient-to-br from-green-600/90 to-teal-700/90"></div>
            <!-- Content -->
            <div class="relative flex-1 flex flex-col justify-center items-center px-8 text-white z-10">
                <div class="max-w-md text-center">
                    <div class="h-20 w-20 sm:h-24 sm:w-24 bg-white/10 backdrop-blur rounded-full flex items-center justify-center mx-auto mb-6 sm:mb-8">
                        <svg class="h-10 w-10 sm:h-12 sm:w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-bold mb-4 sm:mb-6">Welcome Back to Your Fitness Journey</h2>
                    <p class="text-base sm:text-lg text-green-100 mb-6 sm:mb-8">Continue your transformation with personalized workouts, expert guidance, and progress tracking.</p>
                    <div class="flex items-center justify-center space-x-2 text-sm">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Trusted by 10,000+ fitness enthusiasts</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const button = document.getElementById('loginButton');
            const signInText = document.getElementById('signInText');
            const signingInText = document.getElementById('signingInText');
            let isSubmitting = false;
            
            // Reset button state on page load
            function resetButton() {
                signInText.style.display = 'flex';
                signingInText.style.display = 'none';
                signInText.classList.remove('hidden');
                signingInText.classList.add('hidden');
                button.disabled = false;
                isSubmitting = false;
            }
            
            // Set loading state
            function setLoading() {
                signInText.style.display = 'none';
                signingInText.style.display = 'flex';
                signInText.classList.add('hidden');
                signingInText.classList.remove('hidden');
                button.disabled = true;
                isSubmitting = true;
            }
            
            // Initialize button state
            resetButton();
            
            // Handle form submission
            form.addEventListener('submit', function(event) {
                if (isSubmitting) {
                    event.preventDefault();
                    return false;
                }
                
                setLoading();
                
                // Reset after 8 seconds as failsafe
                setTimeout(resetButton, 8000);
            });
            
            // Reset on browser back button or page errors
            window.addEventListener('pageshow', resetButton);
        });
    </script>
</body>
</html>
