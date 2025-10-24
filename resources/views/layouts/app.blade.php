<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Heroicons -->
    <script src="https://unpkg.com/@heroicons/ui@2.0.0/dist/heroicons-ui.min.js" defer></script>

    <!-- Styles -->
    <style>
        :root {
            --trainer-primary: #28a745;
            --trainer-primary-dark: #1e7e34;
            --trainer-secondary: #17a2b8;
            --trainer-accent: #ffc107;
            --trainer-light: #f8f9fa;
            --trainer-dark: #343a40;
        }
        
        .trainer-sidebar {
            background: linear-gradient(135deg, var(--trainer-primary), var(--trainer-primary-dark));
            min-height: 100vh;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .trainer-sidebar .nav-link {
            color: rgba(255,255,255,0.9);
            padding: 12px 20px;
            margin: 4px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .trainer-sidebar .nav-link:hover,
        .trainer-sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(5px);
        }
        
        .trainer-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .trainer-card:hover {
            transform: translateY(-5px);
        }
        
        .trainer-stat-card {
            background: linear-gradient(135deg, var(--trainer-primary), var(--trainer-secondary));
            color: white;
            border-radius: 15px;
            padding: 25px;
        }
        
        .trainer-btn-primary {
            background: var(--trainer-primary);
            border-color: var(--trainer-primary);
            border-radius: 8px;
            padding: 10px 20px;
        }
        
        .trainer-btn-primary:hover {
            background: var(--trainer-primary-dark);
            border-color: var(--trainer-primary-dark);
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <script>
        window.userId = {{ auth()->id() }};
        window.isTrainer = {{ auth()->user() && auth()->user()->user_type === 'trainer' ? 'true' : 'false' }};
    </script>
    <div id="app" x-data="{ sidebarOpen: false }" class="min-h-screen">
        <!-- Sidebar -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 flex lg:hidden" 
             @click.away="sidebarOpen = false">
            <div class="fixed inset-0 bg-black bg-opacity-25"></div>
            
            <div class="relative flex flex-col flex-1 w-full max-w-xs bg-white">
                @include('components.sidebar')
            </div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
            @include('components.sidebar')
        </div>

        <!-- Main content -->
        <div class="lg:pl-72">
            <!-- Top navigation -->
            <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                <button type="button" 
                        class="-m-2.5 p-2.5 text-gray-700 lg:hidden" 
                        @click="sidebarOpen = true">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <div class="h-6 w-px bg-gray-200 lg:hidden" aria-hidden="true"></div>

                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                    <!-- Search bar -->
                    <div class="relative flex flex-1">
                        <input type="search" 
                               placeholder="Search workouts, meals, progress..." 
                               class="block w-full rounded-md border-0 bg-gray-50 py-1.5 pl-10 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <!-- Notifications and profile -->
                    <div class="flex items-center gap-x-4 lg:gap-x-6">
                        <!-- Notifications -->
                        <x-notification-dropdown-updated />

                        <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-200" aria-hidden="true"></div>

                        <!-- Profile dropdown -->
                        <div class="relative" x-data="{ profileOpen: false }">
                            <button type="button" 
                                    class="-m-1.5 flex items-center p-1.5"
                                    @click="profileOpen = !profileOpen">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 rounded-full bg-gray-50" 
                                     src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" 
                                     alt="Profile">
                                <span class="hidden lg:flex lg:items-center">
                                    <span class="ml-4 text-sm font-semibold leading-6 text-gray-900">John Doe</span>
                                    <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </button>

                            <div x-show="profileOpen"
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 @click.away="profileOpen = false"
                                 class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5">
                                <a href="{{ route('profile.index') }}" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">Your profile</a>
                                <a href="{{ route('settings.index') }}" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">Settings</a>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <main class="py-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    {{ $slot ?? '' }}
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>