@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="clientSettingsManager()">
    <!-- Success Toast -->
    <div x-show="showToast" 
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed top-4 right-4 z-50 max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium text-gray-900">Settings saved!</p>
                    <p class="mt-1 text-sm text-gray-500">Your changes have been updated successfully.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Settings</h1>
        <p class="mt-2 text-sm text-gray-600">Manage your account preferences and notification settings.</p>
    </div>

    <!-- Settings Layout with Sidebar Navigation -->
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Navigation -->
        <aside class="lg:w-64 flex-shrink-0">
            <nav class="space-y-1 bg-white rounded-xl shadow-sm border border-gray-200 p-2 lg:sticky lg:top-24" x-data="{ isMobile: window.innerWidth < 1024 }">
                <!-- Mobile: Horizontal Scroll -->
                <div class="lg:hidden overflow-x-auto pb-2">
                    <div class="flex space-x-2">
                        <button @click="activeTab = 'notifications'" 
                                :class="activeTab === 'notifications' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'text-gray-600 hover:bg-gray-50 border-transparent'"
                                class="flex-shrink-0 px-4 py-2 rounded-lg font-medium text-sm transition-colors border-2 whitespace-nowrap">
                            <i class="bi bi-bell mr-2"></i>Notifications
                        </button>
                        <button @click="activeTab = 'account'" 
                                :class="activeTab === 'account' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'text-gray-600 hover:bg-gray-50 border-transparent'"
                                class="flex-shrink-0 px-4 py-2 rounded-lg font-medium text-sm transition-colors border-2 whitespace-nowrap">
                            <i class="bi bi-person mr-2"></i>Account
                        </button>
                        <button @click="activeTab = 'privacy'" 
                                :class="activeTab === 'privacy' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'text-gray-600 hover:bg-gray-50 border-transparent'"
                                class="flex-shrink-0 px-4 py-2 rounded-lg font-medium text-sm transition-colors border-2 whitespace-nowrap">
                            <i class="bi bi-shield-check mr-2"></i>Privacy
                        </button>
                        <button @click="activeTab = 'preferences'" 
                                :class="activeTab === 'preferences' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'text-gray-600 hover:bg-gray-50 border-transparent'"
                                class="flex-shrink-0 px-4 py-2 rounded-lg font-medium text-sm transition-colors border-2 whitespace-nowrap">
                            <i class="bi bi-sliders mr-2"></i>Preferences
                        </button>
                    </div>
                </div>

                <!-- Desktop: Vertical Stack -->
                <div class="hidden lg:block space-y-1">
                    <button @click="activeTab = 'notifications'" 
                            :class="activeTab === 'notifications' ? 'bg-emerald-50 text-emerald-700 border-l-4 border-emerald-600' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent hover:border-gray-300'"
                            class="w-full flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                        <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        Notifications
                    </button>
                    
                    <button @click="activeTab = 'account'" 
                            :class="activeTab === 'account' ? 'bg-emerald-50 text-emerald-700 border-l-4 border-emerald-600' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent hover:border-gray-300'"
                            class="w-full flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                        <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        Account Settings
                    </button>
                    
                    <button @click="activeTab = 'privacy'" 
                            :class="activeTab === 'privacy' ? 'bg-emerald-50 text-emerald-700 border-l-4 border-emerald-600' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent hover:border-gray-300'"
                            class="w-full flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                        <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                        Privacy & Security
                    </button>
                    
                    <button @click="activeTab = 'preferences'" 
                            :class="activeTab === 'preferences' ? 'bg-emerald-50 text-emerald-700 border-l-4 border-emerald-600' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent hover:border-gray-300'"
                            class="w-full flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                        <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                        </svg>
                        Preferences
                    </button>
                </div>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 min-w-0">
            <!-- Notifications Tab -->
            <div x-show="activeTab === 'notifications'" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform translate-x-4"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                
                <div class="bg-gradient-to-r from-emerald-50 to-cyan-50 p-6 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-lg bg-emerald-500 flex items-center justify-center">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-2xl font-bold text-gray-900">Notification Settings</h2>
                            <p class="mt-1 text-sm text-gray-600">Choose how you want to be notified</p>
                        </div>
                    </div>
                </div>

                <form @submit.prevent="submitForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="divide-y divide-gray-100">
                        @if(isset($notificationTypes) && count($notificationTypes) > 0)
                            @foreach($notificationTypes as $type)
                                @php
                                    $preference = $preferences[$type] ?? null;
                                    $title = ucwords(str_replace('_', ' ', $type));
                                    $icons = [
                                        'new_program_assigned' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />',
                                        'program_progress_updated' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />',
                                        'new_message_received' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />',
                                        'appointment_reminder' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 012.25 2.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />'
                                    ];
                                    $description = [
                                        'new_program_assigned' => 'Get notified when a trainer assigns a new workout program to you.',
                                        'program_progress_updated' => 'Receive updates and feedback on your program progress.',
                                        'new_message_received' => 'An alert for new messages from your trainer or support.',
                                        'appointment_reminder' => 'A reminder for an upcoming session or appointment.'
                                    ][$type] ?? 'General notification setting.';
                                @endphp
                                <div class="p-4 sm:p-6 hover:bg-gray-50 transition-colors duration-150">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                        <div class="flex items-start space-x-4 flex-grow">
                                            <div class="flex-shrink-0 mt-1">
                                                <div class="h-10 w-10 rounded-lg bg-emerald-100 flex items-center justify-center">
                                                    <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        {!! $icons[$type] ?? '' !!}
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-grow min-w-0">
                                                <h3 class="text-base sm:text-lg font-semibold text-gray-900">{{ $title }}</h3>
                                                <p class="mt-1 text-sm text-gray-600">{{ $description }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4 sm:space-x-6 pl-14 sm:pl-0">
                                            <!-- In-App Toggle -->
                                            <div class="flex flex-col items-center space-y-2">
                                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">In-App</span>
                                                <input type="hidden" name="notifications[{{ $type }}][in_app]" value="0">
                                                <button type="button" 
                                                        @click="toggleSetting('{{ $type }}', 'in_app')"
                                                        :class="settings['{{ $type }}'].in_app ? 'bg-emerald-600' : 'bg-gray-200'"
                                                        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                                                        role="switch"
                                                        :aria-checked="settings['{{ $type }}'].in_app">
                                                    <span :class="settings['{{ $type }}'].in_app ? 'translate-x-5' : 'translate-x-0'" 
                                                          class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                                </button>
                                                <input type="hidden" 
                                                       :name="'notifications[{{ $type }}][in_app]'" 
                                                       :value="settings['{{ $type }}'].in_app ? '1' : '0'">
                                            </div>
                                            <!-- Email Toggle -->
                                            <div class="flex flex-col items-center space-y-2">
                                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Email</span>
                                                <input type="hidden" name="notifications[{{ $type }}][email]" value="0">
                                                <button type="button"
                                                        @click="toggleSetting('{{ $type }}', 'email')"
                                                        :class="settings['{{ $type }}'].email ? 'bg-emerald-600' : 'bg-gray-200'"
                                                        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                                                        role="switch"
                                                        :aria-checked="settings['{{ $type }}'].email">
                                                    <span :class="settings['{{ $type }}'].email ? 'translate-x-5' : 'translate-x-0'"
                                                          class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                                </button>
                                                <input type="hidden" 
                                                       :name="'notifications[{{ $type }}][email]'" 
                                                       :value="settings['{{ $type }}'].email ? '1' : '0'">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="p-6 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No notification settings available.</p>
                            </div>
                        @endif
                    </div>

                    <div class="bg-gray-50 px-4 sm:px-6 py-4 sm:flex sm:flex-row-reverse border-t border-gray-200">
                        <button type="submit" 
                                :disabled="loading"
                                :class="loading ? 'opacity-75 cursor-not-allowed' : 'hover:bg-emerald-700 hover:shadow-lg'"
                                class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-2.5 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-150">
                            <span x-show="!loading">Save Changes</span>
                            <span x-show="loading" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Saving...
                            </span>
                        </button>
                        <button type="button" 
                                @click="resetToDefaults"
                                class="mt-3 sm:mt-0 sm:mr-3 w-full sm:w-auto inline-flex justify-center items-center px-6 py-2.5 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-150">
                            Reset to Defaults
                        </button>
                    </div>
                </form>
            </div>

            <!-- Account Tab -->
            <div x-show="activeTab === 'account'" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform translate-x-4"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-lg bg-blue-500 flex items-center justify-center">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-2xl font-bold text-gray-900">Account Settings</h2>
                            <p class="mt-1 text-sm text-gray-600">Manage your account information and preferences</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Coming Soon</h3>
                        <p class="mt-2 text-sm text-gray-500">Account settings will be available here.</p>
                    </div>
                </div>
            </div>

            <!-- Privacy Tab -->
            <div x-show="activeTab === 'privacy'" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform translate-x-4"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-lg bg-purple-500 flex items-center justify-center">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-2xl font-bold text-gray-900">Privacy & Security</h2>
                            <p class="mt-1 text-sm text-gray-600">Control your privacy and security settings</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Coming Soon</h3>
                        <p class="mt-2 text-sm text-gray-500">Privacy & security settings will be available here.</p>
                    </div>
                </div>
            </div>

            <!-- Preferences Tab -->
            <div x-show="activeTab === 'preferences'" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform translate-x-4"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 p-6 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-lg bg-amber-500 flex items-center justify-center">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-2xl font-bold text-gray-900">App Preferences</h2>
                            <p class="mt-1 text-sm text-gray-600">Customize your app experience</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Coming Soon</h3>
                        <p class="mt-2 text-sm text-gray-500">App preferences will be available here.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function clientSettingsManager() {
        return {
            loading: false,
            showToast: false,
            activeTab: 'notifications',
            settings: {
                @foreach($notificationTypes as $type)
                    '{{ $type }}': {
                        in_app: {{ ($preferences[$type] ?? null) && $preferences[$type]->in_app ? 'true' : 'false' }},
                        email: {{ ($preferences[$type] ?? null) && $preferences[$type]->email ? 'true' : 'false' }}
                    },
                @endforeach
            },
            toggleSetting(type, channel) {
                this.settings[type][channel] = !this.settings[type][channel];
            },
            resetToDefaults() {
                if (confirm('Are you sure you want to reset all settings to defaults? (In-App: ON, Email: OFF)')) {
                    Object.keys(this.settings).forEach(type => {
                        this.settings[type].in_app = true;
                        this.settings[type].email = false;
                    });
                }
            },
            async submitForm(event) {
                this.loading = true;
                
                // Create FormData from the form
                const formData = new FormData(event.target);
                
                try {
                    const response = await fetch('{{ route('client.settings.update') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    });
                    
                    if (response.ok) {
                        this.showToast = true;
                        setTimeout(() => { this.showToast = false; }, 3000);
                    }
                } catch (error) {
                    console.error('Error saving settings:', error);
                } finally {
                    this.loading = false;
                }
            }
        }
    }
</script>
@endpush
