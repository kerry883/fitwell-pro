<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - FitWell Pro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Fonts - Using Figtree like homepage and trainer dashboard -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-medium text-[#28a745] hover:text-[#1e7e34] transition-colors">Sign in</a>
                </div>
            </div>
        </div>
    </header>

    <div class="min-h-screen py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Create Your FitWell Pro Account</h2>
                <p class="mt-2 text-gray-600">Join thousands of users transforming their fitness journey</p>
            </div>

            <div class="bg-white shadow-xl rounded-xl border border-gray-100 overflow-hidden backdrop-blur-sm bg-white/95">
                <form action="{{ route('register') }}" method="POST" class="p-8" x-data="{ 
                    loading: false, 
                    userType: 'client',
                    showAdvanced: false,
                    currentStep: 1,
                    totalSteps: 2
                }" @submit="loading = true">
                    @csrf
                    
                    <!-- Progress Steps -->
                    <div class="mb-8">
                        <div class="flex items-center justify-center space-x-4">
                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-green-600 text-white text-sm font-semibold">
                                    1
                                </div>
                                <span class="ml-2 text-sm font-medium text-gray-900">Account Info</span>
                            </div>
                            <div class="w-16 h-1 bg-gray-200 rounded">
                                <div class="h-1 bg-green-600 rounded transition-all duration-300" :style="currentStep >= 2 ? 'width: 100%' : 'width: 0%'"></div>
                            </div>
                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full transition-all duration-300"
                                     :class="currentStep >= 2 ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-600'">
                                    2
                                </div>
                                <span class="ml-2 text-sm font-medium" :class="currentStep >= 2 ? 'text-gray-900' : 'text-gray-500'">Profile Setup</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex">
                                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
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

                    <!-- Step 1: Basic Information -->
                    <div x-show="currentStep === 1" class="space-y-6">
                        <!-- User Type Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-4">I want to join as:</label>
                            <div class="grid md:grid-cols-2 gap-4">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="user_type" value="client" x-model="userType" class="sr-only" required>
                                    <div class="border-2 rounded-xl p-6 transition-all duration-200" :class="userType === 'client' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-gray-300'">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-green-600 text-lg"></i>
                                            </div>
                                            <div class="ml-4">
                                                <h3 class="font-semibold text-gray-900">Fitness Client</h3>
                                                <p class="text-sm text-gray-600">Get personalized training and nutrition plans</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer">
                                    <input type="radio" name="user_type" value="trainer" x-model="userType" class="sr-only">
                                    <div class="border-2 rounded-xl p-6 transition-all duration-200" :class="userType === 'trainer' ? 'border-teal-500 bg-teal-50' : 'border-gray-200 hover:border-gray-300'">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 bg-teal-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-dumbbell text-teal-600 text-lg"></i>
                                            </div>
                                            <div class="ml-4">
                                                <h3 class="font-semibold text-gray-900">Personal Trainer</h3>
                                                <p class="text-sm text-gray-600">Train clients and grow your business</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Basic Information -->
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                <input
                                    type="text"
                                    id="first_name"
                                    name="first_name"
                                    value="{{ old('first_name') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                                    placeholder="Enter your first name"
                                    required
                                >
                                @error('first_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                <input
                                    type="text"
                                    id="last_name"
                                    name="last_name"
                                    value="{{ old('last_name') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                                    placeholder="Enter your last name"
                                    required
                                >
                                @error('last_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                                placeholder="Enter your email address"
                                required
                            >
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                                    placeholder="Create a strong password"
                                    required
                                >
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                                    placeholder="Confirm your password"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Continue Button -->
                        <div class="flex justify-end">
                            <button
                                type="button"
                                @click="currentStep = 2"
                                class="bg-gradient-to-r from-[#28a745] to-[#17a2b8] text-white px-8 py-3 rounded-lg font-semibold hover:shadow-lg transition duration-200 transform hover:scale-105"
                            >
                                Continue
                                <svg class="ml-2 h-4 w-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Profile Information -->
                    <div x-show="currentStep === 2" class="space-y-6">
                        <!-- Client-specific fields -->
                        <div x-show="userType === 'client'" class="space-y-6">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h3 class="font-semibold text-blue-900 mb-2">Complete Your Fitness Profile</h3>
                                <p class="text-sm text-blue-700">Help us personalize your experience by sharing some basic fitness information. You can skip this and complete it later if you prefer.</p>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                                    <select
                                        id="gender"
                                        name="gender"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                                    >
                                        <option value="">Select gender</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="age" class="block text-sm font-medium text-gray-700 mb-2">Age</label>
                                    <input
                                        type="number"
                                        id="age"
                                        name="age"
                                        value="{{ old('age') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                                        placeholder="25"
                                        min="13"
                                        max="120"
                                    >
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="height" class="block text-sm font-medium text-gray-700 mb-2">Height (cm)</label>
                                    <input
                                        type="number"
                                        id="height"
                                        name="height"
                                        value="{{ old('height') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                                        placeholder="175"
                                        min="100"
                                        max="250"
                                    >
                                </div>

                                <div>
                                    <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Weight (kg)</label>
                                    <input
                                        type="number"
                                        id="weight"
                                        name="weight"
                                        value="{{ old('weight') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                                        placeholder="70"
                                        min="30"
                                        max="300"
                                        step="0.1"
                                    >
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="fitness_level" class="block text-sm font-medium text-gray-700 mb-2">Fitness Level</label>
                                    <select
                                        id="fitness_level"
                                        name="fitness_level"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                                    >
                                        <option value="">Select your level</option>
                                        <option value="beginner" {{ old('fitness_level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                        <option value="intermediate" {{ old('fitness_level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                        <option value="advanced" {{ old('fitness_level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="activity_level" class="block text-sm font-medium text-gray-700 mb-2">Activity Level</label>
                                    <select
                                        id="activity_level"
                                        name="activity_level"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                                    >
                                        <option value="">Select activity level</option>
                                        <option value="sedentary" {{ old('activity_level') == 'sedentary' ? 'selected' : '' }}>Sedentary</option>
                                        <option value="lightly_active" {{ old('activity_level') == 'lightly_active' ? 'selected' : '' }}>Lightly Active</option>
                                        <option value="moderately_active" {{ old('activity_level') == 'moderately_active' ? 'selected' : '' }}>Moderately Active</option>
                                        <option value="very_active" {{ old('activity_level') == 'very_active' ? 'selected' : '' }}>Very Active</option>
                                        <option value="extremely_active" {{ old('activity_level') == 'extremely_active' ? 'selected' : '' }}>Extremely Active</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="fitness_goals" class="block text-sm font-medium text-gray-700 mb-2">Fitness Goals</label>
                                <textarea
                                    id="fitness_goals"
                                    name="fitness_goals"
                                    rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                                    placeholder="Tell us about your fitness goals..."
                                >{{ old('fitness_goals') }}</textarea>
                            </div>
                        </div>

                        <!-- Trainer-specific fields -->
                        <div x-show="userType === 'trainer'" class="space-y-6">
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                                <h3 class="font-semibold text-purple-900 mb-2">Professional Information</h3>
                                <p class="text-sm text-purple-700">Tell us about your experience and specializations to help clients find you.</p>
                            </div>

                            <div>
                                <label for="gender_trainer" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                                <select
                                    id="gender_trainer"
                                    name="gender"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                                >
                                    <option value="">Select gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div>
                                <label for="specializations" class="block text-sm font-medium text-gray-700 mb-2">Specializations</label>
                                <textarea
                                    id="specializations"
                                    name="specializations"
                                    rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                                    placeholder="Weight loss, strength training, bodybuilding, etc."
                                >{{ old('specializations') }}</textarea>
                            </div>

                            <div>
                                <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Professional Bio</label>
                                <textarea
                                    id="bio"
                                    name="bio"
                                    rows="4"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                                    placeholder="Tell potential clients about your background and approach to fitness..."
                                >{{ old('bio') }}</textarea>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="years_experience" class="block text-sm font-medium text-gray-700 mb-2">Years of Experience</label>
                                    <input
                                        type="number"
                                        id="years_experience"
                                        name="years_experience"
                                        value="{{ old('years_experience') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                                        placeholder="5"
                                        min="0"
                                        max="50"
                                    >
                                </div>
                                
                                <div>
                                    <label for="hourly_rate" class="block text-sm font-medium text-gray-700 mb-2">Hourly Rate ($)</label>
                                    <input
                                        type="number"
                                        id="hourly_rate"
                                        name="hourly_rate"
                                        value="{{ old('hourly_rate') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                                        placeholder="50"
                                        min="1"
                                        max="1000"
                                        step="0.01"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex justify-between pt-6 border-t border-gray-200">
                            <button 
                                type="button" 
                                @click="currentStep = 1"
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition duration-200"
                            >
                                <svg class="mr-2 h-4 w-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                </svg>
                                Back
                            </button>
                            
                            <button
                                type="submit"
                                class="bg-gradient-to-r from-[#28a745] to-[#17a2b8] text-white px-8 py-3 rounded-lg font-semibold hover:shadow-lg transition duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                                :disabled="loading"
                            >
                                <span x-show="!loading" class="flex items-center">
                                    Create Account
                                    <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </span>
                                <span x-show="loading" class="flex items-center">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span class="ml-2">Creating account...</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Social Registration -->
                <div class="px-8 pb-8">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500 font-medium">Or sign up with</span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <a href="{{ route('social.redirect', 'google') }}" class="w-full inline-flex justify-center items-center py-3 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-200">
                            <svg class="h-5 w-5" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            <span class="ml-2">Google</span>
                        </a>
                        
                        <a href="{{ route('social.redirect', 'facebook') }}" class="w-full inline-flex justify-center items-center py-3 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-200">
                            <svg class="h-5 w-5" fill="#1877F2" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            <span class="ml-2">Facebook</span>
                        </a>
                    </div>
                </div>
            </div>

            <p class="text-center text-sm text-gray-600 mt-8">
                By creating an account, you agree to our 
                <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Terms of Service</a> 
                and 
                <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Privacy Policy</a>
            </p>
        </div>
    </div>
</body>
</html>