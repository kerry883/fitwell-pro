<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin Account - FitWell Pro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-inter bg-gray-900 min-h-screen">
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mx-auto h-16 w-16 bg-gradient-to-r from-red-600 to-orange-600 rounded-full flex items-center justify-center">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <h2 class="mt-6 text-3xl font-bold text-white">Create Administrator Account</h2>
                <p class="mt-2 text-sm text-gray-400">
                    Set up a new system administrator account
                </p>
                <div class="mt-2 text-xs text-orange-400 bg-orange-900/20 rounded-lg px-3 py-2">
                    <svg class="h-4 w-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.314 13.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    Restricted admin registration page - not publicly accessible
                </div>
            </div>

            <!-- Form -->
            <div class="bg-gray-800 py-8 px-8 shadow-2xl rounded-xl border border-gray-700">
                <form action="{{ route('admin.register') }}" method="POST" class="space-y-6" x-data="{ loading: false }" @submit="loading = true">
                    @csrf
                    
                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="bg-red-900/50 border border-red-700 rounded-lg p-4">
                            <div class="flex">
                                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-300">Please correct the following errors:</h3>
                                    <div class="mt-2 text-sm text-red-400">
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

                    <!-- Hidden field to set user type as admin -->
                    <input type="hidden" name="user_type" value="admin">

                    <!-- Personal Information -->
                    <div class="space-y-6">
                        <div class="bg-gray-750 border border-gray-600 rounded-lg p-4">
                            <h3 class="font-semibold text-gray-200 mb-2">Administrator Information</h3>
                            <p class="text-sm text-gray-400">Enter the personal details for the new administrator account.</p>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-300 mb-2">First Name</label>
                                <input 
                                    type="text" 
                                    id="first_name" 
                                    name="first_name" 
                                    value="{{ old('first_name') }}"
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-200 text-white placeholder-gray-400" 
                                    placeholder="Enter first name"
                                    required
                                >
                                @error('first_name')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-300 mb-2">Last Name</label>
                                <input 
                                    type="text" 
                                    id="last_name" 
                                    name="last_name" 
                                    value="{{ old('last_name') }}"
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-200 text-white placeholder-gray-400" 
                                    placeholder="Enter last name"
                                    required
                                >
                                @error('last_name')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Admin Email Address</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-200 text-white placeholder-gray-400" 
                                placeholder="admin@fitwellpro.com"
                                required
                            >
                            <p class="mt-1 text-xs text-gray-400">Use a company email address for administrator accounts</p>
                            @error('email')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-200 text-white placeholder-gray-400" 
                                    placeholder="Create secure password"
                                    required
                                >
                                <p class="mt-1 text-xs text-gray-400">Minimum 8 characters with mixed case, numbers, and symbols</p>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirm Password</label>
                                <input 
                                    type="password" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-200 text-white placeholder-gray-400" 
                                    placeholder="Confirm password"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Admin Level Selection -->
                        <div>
                            <label for="admin_level" class="block text-sm font-medium text-gray-300 mb-2">Administrator Level</label>
                            <select 
                                id="admin_level" 
                                name="admin_level" 
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-200 text-white"
                                required
                            >
                                <option value="">Select admin level</option>
                                <option value="super_admin" {{ old('admin_level') == 'super_admin' ? 'selected' : '' }}>Super Administrator (Full Access)</option>
                                <option value="admin" {{ old('admin_level') == 'admin' ? 'selected' : '' }}>Administrator (Standard Access)</option>
                                <option value="moderator" {{ old('admin_level') == 'moderator' ? 'selected' : '' }}>Moderator (Limited Access)</option>
                            </select>
                            <p class="mt-1 text-xs text-gray-400">Super Admins have full system access and can manage other administrators</p>
                        </div>

                        <!-- Department/Role -->
                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-300 mb-2">Department/Role</label>
                            <input 
                                type="text" 
                                id="department" 
                                name="department" 
                                value="{{ old('department') }}"
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-200 text-white placeholder-gray-400" 
                                placeholder="e.g., IT, Customer Support, Management"
                            >
                        </div>

                        <!-- Admin Notes -->
                        <div>
                            <label for="admin_notes" class="block text-sm font-medium text-gray-300 mb-2">Administrative Notes</label>
                            <textarea 
                                id="admin_notes" 
                                name="admin_notes" 
                                rows="3" 
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-200 text-white placeholder-gray-400" 
                                placeholder="Any additional notes about this administrator account..."
                            >{{ old('admin_notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Security Confirmation -->
                    <div class="bg-yellow-900/20 border border-yellow-700 rounded-lg p-4">
                        <div class="flex items-start">
                            <svg class="h-5 w-5 text-yellow-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.314 13.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-yellow-400 mb-1">Security Confirmation</h3>
                                <p class="text-xs text-gray-300 mb-3">By creating this administrator account, you acknowledge that:</p>
                                <ul class="text-xs text-gray-300 space-y-1 list-disc pl-4">
                                    <li>This account will have elevated system privileges</li>
                                    <li>All administrative actions will be logged and audited</li>
                                    <li>The account holder is responsible for maintaining security</li>
                                    <li>Regular password updates are required</li>
                                </ul>
                                <div class="mt-3 flex items-center">
                                    <input 
                                        id="security_acknowledge" 
                                        name="security_acknowledge" 
                                        type="checkbox" 
                                        class="h-4 w-4 text-orange-600 focus:ring-orange-500 bg-gray-700 border-gray-600 rounded"
                                        required
                                    >
                                    <label for="security_acknowledge" class="ml-2 block text-xs text-gray-300">
                                        I acknowledge and accept the security responsibilities
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button 
                            type="submit" 
                            class="w-full bg-gradient-to-r from-red-600 to-orange-600 text-white py-3 px-4 rounded-lg font-semibold hover:shadow-lg transition duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="loading"
                        >
                            <span x-show="!loading" class="flex items-center justify-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                Create Administrator Account
                            </span>
                            <span x-show="loading" class="flex items-center justify-center">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="ml-2">Creating account...</span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Back to Login Link -->
            <div class="text-center mt-6">
                <a href="{{ route('admin.login') }}" class="text-sm font-medium text-orange-400 hover:text-orange-300">
                    &larr; Back to Admin Login
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center mt-8">
        <p class="text-xs text-gray-500">
            &copy; {{ date('Y') }} FitWell Pro. Authorized administrator setup only.
        </p>
    </div>
</body>
</html>