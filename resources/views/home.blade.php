<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitWell Pro - Transform Your Fitness Journey</title>
    <meta name="description" content="FitWell Pro connects you with professional fitness trainers for personalized workout plans, nutrition guidance, and real-time progress tracking.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Fonts - Using Figtree -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Particles.js for hero section -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    
    <style>
        :root {
            /* Theme colors matching trainer dashboard */
            --primary: #28a745;
            --primary-dark: #1e7e34;
            --secondary: #17a2b8;
            --accent: #ffc107;
            --light: #f8f9fa;
            --dark: #343a40;
            --gradient-primary: linear-gradient(135deg, var(--primary), var(--secondary));
            --gradient-accent: linear-gradient(135deg, var(--accent), #ff6b35);
        }

        body {
            font-family: 'Figtree', sans-serif;
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Enhanced animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes pulse-ring {
            0% { transform: scale(0.95); opacity: 1; }
            40% { transform: scale(1.3); opacity: 0; }
            100% { transform: scale(0.95); opacity: 0; }
        }

        @keyframes countUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInUp {
            0% { transform: translateY(100px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        /* Hero section with particles */
        .hero-section {
            position: relative;
            background: var(--gradient-primary);
            min-height: 100vh;
            overflow: hidden;
        }

        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        /* Enhanced navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 2px 30px rgba(0,0,0,0.15);
        }

        /* Stats counters */
        .stats-counter {
            font-size: 3rem;
            font-weight: 800;
            color: white;
        }

        /* Interactive cards */
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient-primary);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            transition: transform 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }

        /* Enhanced buttons */
        .btn-primary-custom {
            background: var(--gradient-primary);
            border: none;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn-primary-custom:hover::before {
            left: 100%;
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(40, 167, 69, 0.4);
        }

        .btn-outline-custom {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: transparent;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(40, 167, 69, 0.3);
        }

        /* Testimonial carousel */
        .testimonial-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
            position: relative;
            margin: 20px;
        }

        .testimonial-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 1rem;
            border: 4px solid var(--primary);
        }

        .stars {
            color: var(--accent);
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }



        /* Trainer cards */
        .trainer-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .trainer-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .trainer-avatar {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .trainer-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--gradient-primary);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Floating elements */
        .floating {
            animation: float 6s ease-in-out infinite;
        }

        .floating-delayed {
            animation: float 6s ease-in-out infinite;
            animation-delay: 2s;
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .stats-counter { font-size: 2rem; }
            .hero-title { font-size: 2.5rem !important; }
            .feature-card { padding: 1.5rem; }
            .testimonial-card { margin: 10px; }
        }

        /* Accessibility improvements */
        .sr-only {
            position: absolute !important;
            width: 1px !important;
            height: 1px !important;
            padding: 0 !important;
            margin: -1px !important;
            overflow: hidden !important;
            clip: rect(0, 0, 0, 0) !important;
            white-space: nowrap !important;
            border: 0 !important;
        }

        /* Focus styles for better accessibility */
        button:focus,
        a:focus,
        input:focus,
        textarea:focus {
            outline: 3px solid var(--accent);
            outline-offset: 2px;
        }

        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .feature-card {
                border: 2px solid var(--dark);
            }
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body class="antialiased" x-data="homePageData()">
    <!-- Enhanced Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md shadow-lg transition-all duration-300" id="mainNavbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo with enhanced branding -->
                <a class="flex items-center" href="#">
                    <div class="p-2 rounded-lg mr-3 bg-gradient-to-r from-green-500 to-cyan-500">
                        <i class="fas fa-bolt text-white text-xl"></i>
                    </div>
                    <span class="font-bold text-2xl text-green-600">FitWell Pro</span>
                </a>

                <!-- Mobile menu button -->
                <button class="md:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500" type="button" @click="mobileMenuOpen = !mobileMenuOpen">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Desktop Navigation menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium transition-colors duration-200" href="#features">Features</a>
                    <a class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium transition-colors duration-200" href="#how-it-works">How It Works</a>
                    <a class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium transition-colors duration-200" href="#trainers">Trainers</a>
                    <a class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium transition-colors duration-200" href="#testimonials">Success Stories</a>
                    <a class="text-gray-700 hover:text-green-600 px-3 py-2 text-sm font-medium transition-colors duration-200" href="#pricing">Pricing</a>
                </div>

                <!-- Login/Register Links -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 px-4 py-2 text-sm font-medium border border-green-600 rounded-full transition-colors duration-200">Sign In</a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-green-500 to-cyan-500 text-white px-6 py-2 text-sm font-medium rounded-full hover:from-green-600 hover:to-cyan-600 transition-all duration-200 shadow-md hover:shadow-lg">Get Started</a>
                </div>
            </div>

            <!-- Mobile Navigation menu -->
            <div class="md:hidden" x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95">
                <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-gray-200">
                    <a class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-green-600 hover:bg-gray-50 rounded-md" href="#features">Features</a>
                    <a class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-green-600 hover:bg-gray-50 rounded-md" href="#how-it-works">How It Works</a>
                    <a class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-green-600 hover:bg-gray-50 rounded-md" href="#trainers">Trainers</a>
                    <a class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-green-600 hover:bg-gray-50 rounded-md" href="#testimonials">Success Stories</a>
                    <a class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-green-600 hover:bg-gray-50 rounded-md" href="#pricing">Pricing</a>
                    <div class="pt-4 pb-3 border-t border-gray-200">
                        <div class="flex items-center px-5 space-x-3">
                            <a href="{{ route('login') }}" class="flex-1 text-center text-green-600 hover:text-green-700 px-4 py-2 text-base font-medium border border-green-600 rounded-full">Sign In</a>
                            <a href="{{ route('register') }}" class="flex-1 text-center bg-gradient-to-r from-green-500 to-cyan-500 text-white px-4 py-2 text-base font-medium rounded-full">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Enhanced Hero Section with Particles -->
    <section class="hero-section flex items-center">
        <div id="particles-js"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 hero-content">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div data-aos="fade-right">
                    <h1 class="hero-title text-white mb-6 text-4xl md:text-5xl lg:text-6xl font-extrabold">
                        Transform Your
                        <span class="text-yellow-400">Fitness Journey</span>
                    </h1>
                    <p class="text-white mb-8 text-xl md:text-2xl opacity-90 leading-relaxed">
                        Connect with certified personal trainers, get personalized workout plans, and achieve your goals with our comprehensive fitness platform.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-wrap gap-4 mb-6">
                        <button class="bg-gradient-to-r from-green-500 to-cyan-500 text-white px-8 py-4 text-lg font-semibold rounded-full hover:from-green-600 hover:to-cyan-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1" @click="startQuiz">
                            <i class="fas fa-play-circle mr-2"></i>Start Free Assessment
                        </button>
                        <a href="#how-it-works" class="border-2 border-white text-white px-8 py-4 text-lg font-semibold rounded-full hover:bg-white hover:text-green-600 transition-all duration-300">
                            <i class="fas fa-arrow-down mr-2"></i>Learn More
                        </a>
                    </div>

                    <!-- Login/Register Links -->
                    <div class="text-center">
                        <small class="text-white opacity-75">
                            Already have an account? <a href="{{ route('login') }}" class="text-white underline hover:text-yellow-400 transition-colors">Sign In</a> |
                            New here? <a href="{{ route('register') }}" class="text-white underline hover:text-yellow-400 transition-colors">Register</a>
                        </small>
                    </div>

                    <!-- Animated Statistics -->
                    <div class="grid grid-cols-3 gap-4 text-center text-white mt-8">
                        <div>
                            <div class="stats-counter text-3xl font-bold" x-text="activeUsers">0</div>
                            <small class="block opacity-75">Active Users</small>
                        </div>
                        <div>
                            <div class="stats-counter text-3xl font-bold" x-text="trainers">0</div>
                            <small class="block opacity-75">Expert Trainers</small>
                        </div>
                        <div>
                            <div class="stats-counter text-3xl font-bold" x-text="successRate + '%'">0</div>
                            <small class="block opacity-75">Success Rate</small>
                        </div>
                    </div>
                </div>
                <div data-aos="fade-left" data-aos-delay="200">
                    <!-- Hero Image/Video Placeholder -->
                    <div class="relative">
                        <div class="bg-white rounded-2xl p-6 shadow-2xl floating">
                            <div class="bg-gray-50 rounded-xl p-8 text-center">
                                <div class="w-24 h-24 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-chart-line text-white text-3xl"></i>
                                </div>
                                <h5 class="text-xl font-semibold mb-2">Real-time Progress Tracking</h5>
                                <p class="text-gray-600">Monitor your fitness journey with detailed analytics</p>
                            </div>
                        </div>
                        <!-- Floating elements -->
                        <div class="absolute -top-4 -right-4 bg-white rounded-full p-3 shadow-lg floating-delayed">
                            <i class="fas fa-heartbeat text-green-500 text-xl"></i>
                        </div>
                        <div class="absolute -bottom-4 -left-4 bg-white rounded-full p-3 shadow-lg floating">
                            <i class="fas fa-trophy text-yellow-400 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Enhanced Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900">Everything You Need to Succeed</h2>
                <p class="text-xl text-gray-600">Comprehensive tools and expert guidance for your transformation</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Enhanced feature cards with hover effects -->
                <div data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-green-200 group h-full">
                        <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-user-check text-white text-2xl"></i>
                        </div>
                        <h5 class="text-center mb-4 text-xl font-semibold">Certified Trainers</h5>
                        <p class="text-gray-600 text-center mb-6">Connect with vetted fitness professionals who create personalized plans.</p>
                        <button class="bg-transparent border border-green-500 text-green-500 px-6 py-2 rounded-full hover:bg-green-500 hover:text-white transition-all duration-300 block mx-auto text-sm font-medium" @click="showFeatureDemo('trainers')">
                            <i class="fas fa-play-circle mr-2"></i>See Demo
                        </button>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-green-200 group h-full">
                        <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-chart-line text-white text-2xl"></i>
                        </div>
                        <h5 class="text-center mb-4 text-xl font-semibold">Progress Analytics</h5>
                        <p class="text-gray-600 text-center mb-6">Track your journey with detailed metrics and insights.</p>
                        <button class="bg-transparent border border-green-500 text-green-500 px-6 py-2 rounded-full hover:bg-green-500 hover:text-white transition-all duration-300 block mx-auto text-sm font-medium" @click="showFeatureDemo('analytics')">
                            <i class="fas fa-play-circle mr-2"></i>See Demo
                        </button>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-green-200 group h-full">
                        <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-calendar-alt text-white text-2xl"></i>
                        </div>
                        <h5 class="text-center mb-4 text-xl font-semibold">Smart Scheduling</h5>
                        <p class="text-gray-600 text-center mb-6">Flexible booking system that adapts to your lifestyle.</p>
                        <button class="bg-transparent border border-green-500 text-green-500 px-6 py-2 rounded-full hover:bg-green-500 hover:text-white transition-all duration-300 block mx-auto text-sm font-medium" @click="showFeatureDemo('scheduling')">
                            <i class="fas fa-play-circle mr-2"></i>See Demo
                        </button>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="400">
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-green-200 group h-full">
                        <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-comments text-white text-2xl"></i>
                        </div>
                        <h5 class="text-center mb-4 text-xl font-semibold">24/7 Support</h5>
                        <p class="text-gray-600 text-center mb-6">Get guidance whenever you need it with our chat system.</p>
                        <button class="bg-transparent border border-green-500 text-green-500 px-6 py-2 rounded-full hover:bg-green-500 hover:text-white transition-all duration-300 block mx-auto text-sm font-medium" @click="showFeatureDemo('support')">
                            <i class="fas fa-play-circle mr-2"></i>See Demo
                        </button>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="500">
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-green-200 group h-full">
                        <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-utensils text-white text-2xl"></i>
                        </div>
                        <h5 class="text-center mb-4 text-xl font-semibold">Nutrition Plans</h5>
                        <p class="text-gray-600 text-center mb-6">Personalized meal plans to complement your training.</p>
                        <button class="bg-transparent border border-green-500 text-green-500 px-6 py-2 rounded-full hover:bg-green-500 hover:text-white transition-all duration-300 block mx-auto text-sm font-medium" @click="showFeatureDemo('nutrition')">
                            <i class="fas fa-play-circle mr-2"></i>See Demo
                        </button>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="600">
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-green-200 group h-full">
                        <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-video text-white text-2xl"></i>
                        </div>
                        <h5 class="text-center mb-4 text-xl font-semibold">Video Assessment</h5>
                        <p class="text-gray-600 text-center mb-6">Get personalized fitness plans through video assessment with our expert trainers.</p>
                        <button class="bg-transparent border border-green-500 text-green-500 px-6 py-2 rounded-full hover:bg-green-500 hover:text-white transition-all duration-300 block mx-auto text-sm font-medium" @click="showFeatureDemo('assessment')">
                            <i class="fas fa-play-circle mr-2"></i>See Demo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900">How It Works</h2>
                <p class="text-xl text-gray-600">Get started in just 3 simple steps</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
                <div data-aos="fade-right">
                    <div class="text-center">
                        <div class="w-24 h-24 bg-gradient-to-r from-green-500 to-cyan-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <span class="font-bold text-white text-2xl">1</span>
                        </div>
                        <h5 class="text-xl font-semibold mb-4">Take Assessment</h5>
                        <p class="text-gray-600">Complete our fitness quiz to understand your goals and fitness level</p>
                    </div>
                </div>
                <div data-aos="fade-up" data-aos-delay="200">
                    <div class="text-center">
                        <div class="w-24 h-24 bg-gradient-to-r from-green-500 to-cyan-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <span class="font-bold text-white text-2xl">2</span>
                        </div>
                        <h5 class="text-xl font-semibold mb-4">Match with Trainer</h5>
                        <p class="text-gray-600">Get paired with a certified trainer who specializes in your needs</p>
                    </div>
                </div>
                <div data-aos="fade-left" data-aos-delay="400">
                    <div class="text-center">
                        <div class="w-24 h-24 bg-gradient-to-r from-green-500 to-cyan-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <span class="font-bold text-white text-2xl">3</span>
                        </div>
                        <h5 class="text-xl font-semibold mb-4">Start Training</h5>
                        <p class="text-gray-600">Begin your personalized workout plan and track your progress</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Stories & Testimonials -->
    <section id="testimonials" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900">Success Stories</h2>
                <p class="text-xl text-gray-600">Real transformations from real people</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-aos="fade-up" data-aos-delay="200">
                <div>
                    <div class="testimonial-card">
                        <img src="https://via.placeholder.com/80x80" class="testimonial-avatar" alt="Sarah M.">
                        <div class="stars">★★★★★</div>
                        <p class="mb-4 text-gray-700">"Lost 30 pounds in 6 months! My trainer Sarah was amazing - she kept me motivated and created a plan that fit my busy schedule."</p>
                        <h6 class="font-bold text-lg mb-1">Sarah M.</h6>
                        <small class="text-gray-500">Marketing Manager</small>
                        <div class="mt-4">
                            <span class="inline-block bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">Weight Loss: -30lbs</span>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="testimonial-card">
                        <img src="https://via.placeholder.com/80x80" class="testimonial-avatar" alt="Mike R.">
                        <div class="stars">★★★★★</div>
                        <p class="mb-4 text-gray-700">"Gained 15 pounds of muscle and improved my strength by 40%. The nutrition guidance was a game-changer!"</p>
                        <h6 class="font-bold text-lg mb-1">Mike R.</h6>
                        <small class="text-gray-500">Software Engineer</small>
                        <div class="mt-4">
                            <span class="inline-block bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-medium">Muscle Gain: +15lbs</span>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="testimonial-card">
                        <img src="https://via.placeholder.com/80x80" class="testimonial-avatar" alt="Emma L.">
                        <div class="stars">★★★★★</div>
                        <p class="mb-4 text-gray-700">"Completed my first marathon after working with my trainer for 8 months. Couldn't have done it without FitWell Pro!"</p>
                        <h6 class="font-bold text-lg mb-1">Emma L.</h6>
                        <small class="text-gray-500">Teacher</small>
                        <div class="mt-4">
                            <span class="inline-block bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-medium">Marathon Finisher</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media Integration -->
            <div class="text-center mt-16">
                <h5 class="text-xl font-semibold mb-8">Follow Our Community</h5>
                <div class="flex justify-center gap-4">
                    <a href="#" class="w-12 h-12 border border-green-500 text-green-500 rounded-full flex items-center justify-center hover:bg-green-500 hover:text-white transition-colors duration-200">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-12 h-12 border border-green-500 text-green-500 rounded-full flex items-center justify-center hover:bg-green-500 hover:text-white transition-colors duration-200">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-12 h-12 border border-green-500 text-green-500 rounded-full flex items-center justify-center hover:bg-green-500 hover:text-white transition-colors duration-200">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="w-12 h-12 border border-green-500 text-green-500 rounded-full flex items-center justify-center hover:bg-green-500 hover:text-white transition-colors duration-200">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Trainer Preview -->
    <section id="trainers" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900">Meet Our Expert Trainers</h2>
                <p class="text-xl text-gray-600">Certified professionals ready to guide your journey</p>
            </div>

            <!-- Trainer Filters -->
            <div class="flex justify-center mb-12" data-aos="fade-up" data-aos-delay="200">
                <div class="flex flex-wrap gap-2" role="group">
                    <button class="px-6 py-2 border border-green-500 text-green-500 rounded-full hover:bg-green-500 hover:text-white transition-all duration-200 font-medium" @click="filterTrainers('all')" :class="{ 'bg-green-500 text-white': trainerFilter === 'all' }">All</button>
                    <button class="px-6 py-2 border border-green-500 text-green-500 rounded-full hover:bg-green-500 hover:text-white transition-all duration-200 font-medium" @click="filterTrainers('strength')" :class="{ 'bg-green-500 text-white': trainerFilter === 'strength' }">Strength</button>
                    <button class="px-6 py-2 border border-green-500 text-green-500 rounded-full hover:bg-green-500 hover:text-white transition-all duration-200 font-medium" @click="filterTrainers('cardio')" :class="{ 'bg-green-500 text-white': trainerFilter === 'cardio' }">Cardio</button>
                    <button class="px-6 py-2 border border-green-500 text-green-500 rounded-full hover:bg-green-500 hover:text-white transition-all duration-200 font-medium" @click="filterTrainers('yoga')" :class="{ 'bg-green-500 text-white': trainerFilter === 'yoga' }">Yoga</button>
                    <button class="px-6 py-2 border border-green-500 text-green-500 rounded-full hover:bg-green-500 hover:text-white transition-all duration-200 font-medium" @click="filterTrainers('nutrition')" :class="{ 'bg-green-500 text-white': trainerFilter === 'nutrition' }">Nutrition</button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-aos="fade-up" data-aos-delay="400">
                <template x-for="trainer in filteredTrainers" :key="trainer.id">
                    <div class="trainer-card">
                        <div class="relative">
                            <img :src="trainer.image" class="trainer-avatar" :alt="trainer.name">
                            <div class="trainer-badge" x-text="trainer.specialty"></div>
                        </div>
                        <div class="p-6">
                            <h5 x-text="trainer.name" class="mb-2 text-xl font-semibold"></h5>
                            <p class="text-gray-600 mb-4" x-text="trainer.bio"></p>
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="stars mr-2" x-html="'★'.repeat(trainer.rating) + '☆'.repeat(5-trainer.rating)"></div>
                                    <span class="text-gray-500" x-text="`(${trainer.reviews})`"></span>
                                </div>
                                <span class="inline-block bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium" x-text="`${trainer.experience}+ years`"></span>
                            </div>
                            <div class="flex gap-3">
                                <button class="bg-gradient-to-r from-green-500 to-cyan-500 text-white px-4 py-2 text-sm font-medium rounded-full hover:from-green-600 hover:to-cyan-600 transition-all duration-200 flex-1 flex items-center justify-center" @click="scheduleWithTrainer(trainer.id)">
                                    <i class="fas fa-calendar-plus mr-2"></i>Schedule
                                </button>
                                <button class="border border-gray-300 text-gray-600 px-4 py-2 text-sm font-medium rounded-full hover:bg-gray-50 transition-colors duration-200" @click="viewTrainerProfile(trainer.id)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>

    <!-- Enhanced Pricing Section -->
    <section id="pricing" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900">Choose Your Plan</h2>
                <p class="text-xl text-gray-600">Flexible pricing to fit your lifestyle</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 justify-items-center" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-green-200 text-center h-full w-full max-w-sm">
                    <h5 class="text-2xl font-semibold mb-4">Starter</h5>
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-gray-900">$49</span>
                        <span class="text-gray-500">/month</span>
                    </div>
                    <ul class="text-left mb-8 space-y-3">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>2 sessions per month</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Basic progress tracking</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Email support</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Mobile app access</li>
                    </ul>
                    <a href="{{ route('register') }}" class="inline-block w-full border border-green-500 text-green-500 px-6 py-3 rounded-full hover:bg-green-500 hover:text-white transition-all duration-300 font-medium">Get Started</a>
                </div>
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-green-500 text-center h-full w-full max-w-sm relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <span class="bg-gradient-to-r from-green-500 to-cyan-500 text-white px-4 py-2 rounded-full text-sm font-medium">Most Popular</span>
                    </div>
                    <h5 class="text-2xl font-semibold mb-4 mt-4">Professional</h5>
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-gray-900">$99</span>
                        <span class="text-gray-500">/month</span>
                    </div>
                    <ul class="text-left mb-8 space-y-3">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>8 sessions per month</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Advanced analytics</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Nutrition planning</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>24/7 chat support</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Custom meal plans</li>
                    </ul>
                    <a href="{{ route('register') }}" class="inline-block w-full bg-gradient-to-r from-green-500 to-cyan-500 text-white px-6 py-3 rounded-full hover:from-green-600 hover:to-cyan-600 transition-all duration-300 font-medium shadow-md hover:shadow-lg">Get Started</a>
                </div>
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-green-200 text-center h-full w-full max-w-sm">
                    <h5 class="text-2xl font-semibold mb-4">Elite</h5>
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-gray-900">$199</span>
                        <span class="text-gray-500">/month</span>
                    </div>
                    <ul class="text-left mb-8 space-y-3">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Unlimited sessions</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Premium analytics</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Personal nutritionist</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Priority support</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Exclusive content</li>
                    </ul>
                    <a href="{{ route('register') }}" class="inline-block w-full border border-green-500 text-green-500 px-6 py-3 rounded-full hover:bg-green-500 hover:text-white transition-all duration-300 font-medium">Get Started</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-20 bg-gradient-to-r from-green-500 to-cyan-500">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white" data-aos="zoom-in">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">Ready to Transform Your Life?</h2>
            <p class="text-xl md:text-2xl mb-8 opacity-90">Join thousands who've already started their fitness journey</p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-white text-green-600 px-8 py-4 text-lg font-semibold rounded-full hover:bg-gray-100 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <i class="fas fa-rocket mr-3"></i>Start Free Trial
                </a>
                <button class="border-2 border-white text-white px-8 py-4 text-lg font-semibold rounded-full hover:bg-white hover:text-green-600 transition-all duration-300" @click="startQuiz">
                    <i class="fas fa-clipboard-check mr-3"></i>Take Assessment
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-6">
                        <div class="p-3 rounded-lg mr-4 bg-gradient-to-r from-green-500 to-cyan-500">
                            <i class="fas fa-bolt text-white text-xl"></i>
                        </div>
                        <span class="font-bold text-2xl text-green-400">FitWell Pro</span>
                    </div>
                    <p class="text-gray-300 mb-6 leading-relaxed">Transform your fitness journey with personalized training and expert guidance.</p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 border border-gray-600 text-gray-400 rounded-full flex items-center justify-center hover:bg-gray-800 hover:text-white transition-colors duration-200">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 border border-gray-600 text-gray-400 rounded-full flex items-center justify-center hover:bg-gray-800 hover:text-white transition-colors duration-200">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 border border-gray-600 text-gray-400 rounded-full flex items-center justify-center hover:bg-gray-800 hover:text-white transition-colors duration-200">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h6 class="font-bold mb-6 text-lg">Features</h6>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Personal Training</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Nutrition Plans</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Progress Tracking</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Mobile App</a></li>
                    </ul>
                </div>
                <div>
                    <h6 class="font-bold mb-6 text-lg">Support</h6>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Help Center</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Contact Us</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Terms of Service</a></li>
                    </ul>
                </div>
                <div>
                    <h6 class="font-bold mb-6 text-lg">Video Assessment</h6>
                    <p class="text-gray-300 mb-6 leading-relaxed">Get personalized fitness plans through video assessment with our expert trainers</p>
                    <div class="flex flex-wrap gap-3">
                        <a href="#features" class="bg-gradient-to-r from-green-500 to-cyan-500 text-white px-4 py-2 text-sm font-medium rounded-lg hover:from-green-600 hover:to-cyan-600 transition-colors duration-200 flex items-center">
                            <i class="fas fa-video mr-2"></i>Try Assessment
                        </a>
                        <a href="#how-it-works" class="border border-gray-600 text-gray-300 px-4 py-2 text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors duration-200 flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>Learn More
                        </a>
                    </div>
                </div>
            </div>
            <hr class="my-12 border-gray-700">
            <div class="text-center text-gray-400">
                <p class="mb-0">&copy; 2024 FitWell Pro. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Alpine.js data
        function homePageData() {
            return {
                // Animation counters
                activeUsers: 0,
                trainers: 0,
                successRate: 0,
                
                // Trainer filtering
                trainerFilter: 'all',
                trainers: [
                    {
                        id: 1,
                        name: 'Sarah Johnson',
                        specialty: 'Strength',
                        bio: 'Certified strength coach with 8+ years experience',
                        rating: 5,
                        reviews: 127,
                        experience: 8,
                        image: 'https://via.placeholder.com/400x200'
                    },
                    {
                        id: 2,
                        name: 'Mike Chen',
                        specialty: 'Cardio',
                        bio: 'Marathon runner and cardio specialist',
                        rating: 5,
                        reviews: 89,
                        experience: 6,
                        image: 'https://via.placeholder.com/400x200'
                    },
                    {
                        id: 3,
                        name: 'Emma Wilson',
                        specialty: 'Yoga',
                        bio: 'Certified yoga instructor and mindfulness coach',
                        rating: 5,
                        reviews: 156,
                        experience: 10,
                        image: 'https://via.placeholder.com/400x200'
                    },
                    {
                        id: 4,
                        name: 'David Rodriguez',
                        specialty: 'Nutrition',
                        bio: 'Licensed nutritionist and meal planning expert',
                        rating: 4,
                        reviews: 94,
                        experience: 7,
                        image: 'https://via.placeholder.com/400x200'
                    }
                ],
                
                quizQuestions: [
                    {
                        id: 1,
                        question: 'What is your primary fitness goal?',
                        options: [
                            { id: 'goal_1', text: 'Lose weight', value: 'weight_loss' },
                            { id: 'goal_2', text: 'Build muscle', value: 'muscle_gain' },
                            { id: 'goal_3', text: 'Improve endurance', value: 'endurance' },
                            { id: 'goal_4', text: 'General fitness', value: 'general' }
                        ]
                    },
                    {
                        id: 2,
                        question: 'How often do you currently exercise?',
                        options: [
                            { id: 'freq_1', text: 'Never', value: 'never' },
                            { id: 'freq_2', text: '1-2 times per week', value: 'sometimes' },
                            { id: 'freq_3', text: '3-4 times per week', value: 'regularly' },
                            { id: 'freq_4', text: '5+ times per week', value: 'very_active' }
                        ]
                    },
                    {
                        id: 3,
                        question: 'What type of training do you prefer?',
                        options: [
                            { id: 'type_1', text: 'Strength training', value: 'strength' },
                            { id: 'type_2', text: 'Cardio workouts', value: 'cardio' },
                            { id: 'type_3', text: 'Yoga/Flexibility', value: 'yoga' },
                            { id: 'type_4', text: 'Mixed training', value: 'mixed' }
                        ]
                    }
                ],

                init() {
                    // Initialize AOS
                    AOS.init({
                        duration: 1000,
                        once: true,
                        offset: 100
                    });

                    // Initialize particles
                    this.initParticles();

                    // Animate counters
                    this.animateCounters();

                    // Handle navbar scrolling
                    this.handleNavbarScroll();
                },

                get filteredTrainers() {
                    if (this.trainerFilter === 'all') {
                        return this.trainers;
                    }
                    return this.trainers.filter(trainer => 
                        trainer.specialty.toLowerCase() === this.trainerFilter
                    );
                },

                initParticles() {
                    if (window.particlesJS) {
                        particlesJS('particles-js', {
                            particles: {
                                number: { value: 80, density: { enable: true, value_area: 800 } },
                                color: { value: '#ffffff' },
                                shape: { type: 'circle' },
                                opacity: { value: 0.5, random: false },
                                size: { value: 3, random: true },
                                line_linked: {
                                    enable: true,
                                    distance: 150,
                                    color: '#ffffff',
                                    opacity: 0.4,
                                    width: 1
                                },
                                move: {
                                    enable: true,
                                    speed: 6,
                                    direction: 'none',
                                    random: false,
                                    straight: false,
                                    out_mode: 'out',
                                    bounce: false
                                }
                            },
                            interactivity: {
                                detect_on: 'canvas',
                                events: {
                                    onhover: { enable: true, mode: 'repulse' },
                                    onclick: { enable: true, mode: 'push' },
                                    resize: true
                                }
                            },
                            retina_detect: true
                        });
                    }
                },

                animateCounters() {
                    const targets = { users: 2500, trainers: 150, success: 95 };
                    const duration = 2000;
                    const steps = 50;
                    const stepTime = duration / steps;

                    let step = 0;
                    const interval = setInterval(() => {
                        step++;
                        const progress = step / steps;
                        
                        this.activeUsers = Math.floor(targets.users * progress);
                        this.trainers = Math.floor(targets.trainers * progress);
                        this.successRate = Math.floor(targets.success * progress);

                        if (step >= steps) {
                            clearInterval(interval);
                        }
                    }, stepTime);
                },

                handleNavbarScroll() {
                    const navbar = document.getElementById('mainNavbar');
                    window.addEventListener('scroll', () => {
                        if (window.scrollY > 100) {
                            navbar.classList.add('scrolled');
                        } else {
                            navbar.classList.remove('scrolled');
                        }
                    });
                },

                startQuiz() {
                    this.showQuiz = true;
                    this.currentQuestion = 0;
                    this.quizAnswers = [];
                    this.quizCompleted = false;
                },

                closeQuiz() {
                    this.showQuiz = false;
                    this.currentQuestion = 0;
                    this.quizAnswers = [];
                    this.quizCompleted = false;
                    this.quizResult = '';
                },

                selectAnswer(answer) {
                    this.quizAnswers[this.currentQuestion] = answer;
                    
                    if (this.currentQuestion < this.quizQuestions.length - 1) {
                        this.currentQuestion++;
                    } else {
                        this.completeQuiz();
                    }
                },

                completeQuiz() {
                    this.quizCompleted = true;
                    
                    // Generate personalized result
                    const goal = this.quizAnswers[0];
                    const frequency = this.quizAnswers[1];
                    const preference = this.quizAnswers[2];

                    let result = 'Based on your responses, we recommend ';
                    
                    if (goal === 'weight_loss') {
                        result += 'our Professional plan with cardio-focused training and nutrition support.';
                    } else if (goal === 'muscle_gain') {
                        result += 'our Professional plan with strength training and protein-rich meal plans.';
                    } else if (goal === 'endurance') {
                        result += 'our Professional plan with endurance training and performance nutrition.';
                    } else {
                        result += 'our Starter plan to build healthy habits and general fitness.';
                    }

                    this.quizResult = result;
                },

                filterTrainers(filter) {
                    this.trainerFilter = filter;
                },

                scheduleWithTrainer(trainerId) {
                    // In a real app, this would open a scheduling modal or redirect
                    alert(`Scheduling session with trainer ${trainerId}. This would open the booking system.`);
                },

                viewTrainerProfile(trainerId) {
                    // In a real app, this would show detailed trainer profile
                    alert(`Viewing trainer ${trainerId} profile. This would show detailed information.`);
                },

                showFeatureDemo(feature) {
                    // In a real app, this would show feature demonstrations
                    alert(`Showing ${feature} demo. This would display an interactive preview.`);
                }
            }
        }

        // Accessibility enhancements
        document.addEventListener('DOMContentLoaded', function() {
            // Add keyboard navigation for cards
            const cards = document.querySelectorAll('.feature-card, .trainer-card, .testimonial-card');
            cards.forEach(card => {
                card.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        const button = card.querySelector('button, a');
                        if (button) button.click();
                    }
                });
            });

            // Lazy loading for images
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.classList.remove('skeleton');
                            observer.unobserve(img);
                        }
                    });
                });

                document.querySelectorAll('img[data-src]').forEach(img => {
                    img.classList.add('skeleton');
                    imageObserver.observe(img);
                });
            }
        });
    </script>
</body>
</html>