<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Trainer Dashboard') - {{ config('app.name', 'FitWell Pro') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Custom Trainer Styles -->
    <style>
        :root {
            --trainer-primary: #28a745;
            --trainer-primary-dark: #1e7e34;
            --trainer-secondary: #17a2b8;
            --trainer-accent: #ffc107;
            --trainer-light: #f8f9fa;
            --trainer-dark: #343a40;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8f9fa;
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

        .trainer-header {
            background: white;
            border-bottom: 1px solid #dee2e6;
            padding: 15px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .trainer-profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid var(--trainer-primary);
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

        .client-status-active {
            background-color: var(--trainer-primary);
            color: white;
        }

        .client-status-inactive {
            background-color: #dc3545;
            color: white;
        }

        .progress-excellent {
            color: var(--trainer-primary);
        }

        .progress-improving {
            color: var(--trainer-secondary);
        }

        .progress-on-track {
            color: var(--trainer-accent);
        }

        /* Notification Dropdown Specific Styles */
        .dropdown-menu.notification-dropdown {
            position: absolute !important;
            z-index: 1050 !important;
            will-change: transform;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        }

        .notification-item {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .notification-item:hover {
            background-color: #f8f9fa !important;
            transform: translateX(2px);
        }

        .notification-badge {
            font-size: 0.6rem;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        .toast-container {
            z-index: 1055 !important;
        }

        /* Fix for dropdown positioning conflicts */
        .trainer-header .dropdown {
            position: static;
        }

        .trainer-header .dropdown-menu {
            position: absolute;
            right: 0;
            left: auto;
            transform: none;
        }
    </style>

    @stack('styles')
</head>
<body>
    <script>
        window.userId = {{ auth()->id() }};
        window.isTrainer = {{ auth()->user()->isTrainer() ? true : false }};
    </script>
    <div class="container-fluid">
        <div class="row">
            <!-- Trainer Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="trainer-sidebar position-fixed" style="width: inherit; z-index: 1000;">
                    <!-- Trainer Profile Section -->
                    <div class="p-4 border-bottom border-light border-opacity-25">
                        <div class="text-center">
                            @if(Auth::user()->profile_picture)
                                <img src="{{ Storage::url(Auth::user()->profile_picture) }}" 
                                     alt="Profile" class="trainer-profile-img mb-2">
                            @else
                                <div class="trainer-profile-img bg-light d-flex align-items-center justify-content-center mb-2 mx-auto">
                                    <i class="bi bi-person-circle text-muted" style="font-size: 1.5rem;"></i>
                                </div>
                            @endif
                            <h6 class="text-white mb-1">{{ Auth::user()->full_name }}</h6>
                            <small class="text-white-50">Personal Trainer</small>
                        </div>
                    </div>

                    <!-- Navigation Menu -->
                    <nav class="nav flex-column py-3">
                        <a href="{{ route('trainer.dashboard') }}" 
                           class="nav-link {{ request()->routeIs('trainer.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-house-door me-2"></i> Dashboard
                        </a>
                        <a href="{{ route('trainer.clients.index') }}" 
                           class="nav-link {{ request()->routeIs('trainer.clients.*') ? 'active' : '' }}">
                            <i class="bi bi-people me-2"></i> My Clients
                        </a>
                        <a href="{{ route('trainer.programs.index') }}" 
                           class="nav-link {{ request()->routeIs('trainer.programs.*') ? 'active' : '' }}">
                            <i class="bi bi-journal-text me-2"></i> Programs
                        </a>
                        <a href="{{ route('trainer.schedule.index') }}" 
                           class="nav-link {{ request()->routeIs('trainer.schedule.*') ? 'active' : '' }}">
                            <i class="bi bi-calendar3 me-2"></i> Schedule
                        </a>
                        <a href="{{ route('trainer.analytics.index') }}" 
                           class="nav-link {{ request()->routeIs('trainer.analytics.*') ? 'active' : '' }}">
                            <i class="bi bi-bar-chart me-2"></i> Analytics
                        </a>
                        <a href="{{ route('trainer.profile.index') }}" 
                           class="nav-link {{ request()->routeIs('trainer.profile.*') ? 'active' : '' }}">
                            <i class="bi bi-person-gear me-2"></i> Profile
                        </a>
                        <a href="{{ route('trainer.settings.index') }}" 
                           class="nav-link {{ request()->routeIs('settings.index') ? 'active' : '' }}">
                            <i class="bi bi-gear me-2"></i> Settings
                        </a>
                        
                        <!-- Logout -->
                        <div class="mt-auto pt-4">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ms-sm-auto">
                <!-- Top Header -->
                <header class="trainer-header sticky-top">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
                                <small class="text-muted">@yield('page-subtitle', 'Welcome back, ' . Auth::user()->first_name . '!')</small>
                            </div>
                            <div class="col-auto">
                                <div class="d-flex align-items-center gap-3">
                                    <!-- Notifications -->
                                    <x-trainer-notification-dropdown />

                                    <!-- Profile Dropdown -->
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm d-flex align-items-center" data-bs-toggle="dropdown">
                                            @if(Auth::user()->profile_picture)
                                                <img src="{{ Storage::url(Auth::user()->profile_picture) }}" 
                                                     alt="Profile" class="me-2" style="width: 24px; height: 24px; border-radius: 50%;">
                                            @else
                                                <i class="bi bi-person-circle me-2"></i>
                                            @endif
                                            {{ Auth::user()->first_name }}
                                            <i class="bi bi-chevron-down ms-2"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="{{ route('trainer.profile.index') }}">
                                                <i class="bi bi-person me-2"></i> Profile
                                            </a>
                                            <a class="dropdown-item" href="{{ route('trainer.settings.index') }}">
                                                <i class="bi bi-gear me-2"></i> Settings
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>