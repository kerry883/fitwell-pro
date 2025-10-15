<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitWell Pro - Transform Your Fitness Journey</title>
    <meta name="description" content="FitWell Pro connects you with professional fitness trainers for personalized workout plans, nutrition guidance, and real-time progress tracking.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Fonts - Using same as trainer dashboard (Figtree) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Bootstrap CSS & Icons - Consistent with trainer dashboard -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
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
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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

        /* Quiz modal */
        .quiz-modal {
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(5px);
        }

        .quiz-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            max-width: 600px;
            width: 90%;
        }

        .quiz-progress {
            height: 8px;
            background: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .quiz-progress-bar {
            height: 100%;
            background: var(--gradient-primary);
            transition: width 0.3s ease;
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

        /* Skeleton loading animations */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
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
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNavbar">
        <div class="container">
            <!-- Logo with enhanced branding -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <div class="p-2 rounded-3 me-3" style="background: var(--gradient-primary);">
                    <i class="bi bi-lightning text-white" style="font-size: 1.5rem;"></i>
                </div>
                <span class="fw-bold fs-3" style="color: var(--primary);">FitWell Pro</span>
            </a>

            <!-- Mobile toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#how-it-works">How It Works</a></li>
                    <li class="nav-item"><a class="nav-link" href="#trainers">Trainers</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimonials">Success Stories</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>
                </ul>
                <div class="d-flex align-items-center">
                    <a href="{{ route('login') }}" class="btn btn-outline-custom me-3">Sign In</a>
                    <a href="{{ route('register') }}" class="btn btn-primary-custom">Get Started</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Enhanced Hero Section with Particles -->
    <section class="hero-section d-flex align-items-center">
        <div id="particles-js"></div>
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="hero-title text-white mb-4" style="font-size: 3.5rem; font-weight: 800;">
                        Transform Your 
                        <span style="color: var(--accent);">Fitness Journey</span>
                    </h1>
                    <p class="lead text-white mb-5" style="font-size: 1.3rem; opacity: 0.9;">
                        Connect with certified personal trainers, get personalized workout plans, and achieve your goals with our comprehensive fitness platform.
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="d-flex flex-wrap gap-3 mb-5">
                        <button class="btn btn-primary-custom btn-lg" @click="startQuiz">
                            <i class="bi bi-play-circle me-2"></i>Start Free Assessment
                        </button>
                        <a href="#how-it-works" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-arrow-down-circle me-2"></i>Learn More
                        </a>
                    </div>

                    <!-- Animated Statistics -->
                    <div class="row text-center text-white">
                        <div class="col-4">
                            <div class="stats-counter" x-text="activeUsers">0</div>
                            <small class="d-block opacity-75">Active Users</small>
                        </div>
                        <div class="col-4">
                            <div class="stats-counter" x-text="trainers">0</div>
                            <small class="d-block opacity-75">Expert Trainers</small>
                        </div>
                        <div class="col-4">
                            <div class="stats-counter" x-text="successRate + '%'">0</div>
                            <small class="d-block opacity-75">Success Rate</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                    <!-- Hero Image/Video Placeholder -->
                    <div class="position-relative">
                        <div class="bg-white rounded-4 p-4 shadow-lg floating">
                            <div class="bg-light rounded-3 p-5 text-center">
                                <div class="feature-icon mx-auto mb-3" style="width: 100px; height: 100px;">
                                    <i class="bi bi-activity text-white" style="font-size: 2.5rem;"></i>
                                </div>
                                <h5>Real-time Progress Tracking</h5>
                                <p class="text-muted mb-0">Monitor your fitness journey with detailed analytics</p>
                            </div>
                        </div>
                        <!-- Floating elements -->
                        <div class="position-absolute top-0 end-0 bg-white rounded-circle p-3 shadow floating-delayed" style="margin-top: -20px; margin-right: -20px;">
                            <i class="bi bi-heart-pulse" style="color: var(--primary); font-size: 1.5rem;"></i>
                        </div>
                        <div class="position-absolute bottom-0 start-0 bg-white rounded-circle p-3 shadow floating" style="margin-bottom: -20px; margin-left: -20px;">
                            <i class="bi bi-trophy" style="color: var(--accent); font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Fitness Quiz Modal -->
    <div class="quiz-modal position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" 
         x-show="showQuiz" x-transition style="z-index: 9999;">
        <div class="quiz-card" data-aos="zoom-in">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">Fitness Assessment</h3>
                <button class="btn-close" @click="closeQuiz"></button>
            </div>
            
            <!-- Progress Bar -->
            <div class="quiz-progress">
                <div class="quiz-progress-bar" :style="`width: ${(currentQuestion + 1) / quizQuestions.length * 100}%`"></div>
            </div>

            <!-- Question -->
            <div x-show="currentQuestion < quizQuestions.length">
                <h5 x-text="quizQuestions[currentQuestion]?.question" class="mb-4"></h5>
                <div class="d-grid gap-2">
                    <template x-for="option in quizQuestions[currentQuestion]?.options" :key="option.value">
                        <button class="btn btn-outline-primary text-start p-3" 
                                @click="selectAnswer(option.value)" 
                                x-text="option.text"></button>
                    </template>
                </div>
            </div>

            <!-- Results -->
            <div x-show="currentQuestion >= quizQuestions.length && quizCompleted">
                <div class="text-center">
                    <i class="bi bi-trophy text-warning mb-3" style="font-size: 3rem;"></i>
                    <h4 class="mb-3">Your Personalized Plan</h4>
                    <p x-text="quizResult" class="mb-4"></p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('register') }}" class="btn btn-primary-custom flex-fill">Start Journey</a>
                        <button class="btn btn-outline-secondary" @click="closeQuiz">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Features Section -->
    <section id="features" class="py-5" style="background: var(--light);">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-4 fw-bold mb-3" style="color: var(--dark);">Everything You Need to Succeed</h2>
                <p class="lead text-muted">Comprehensive tools and expert guidance for your transformation</p>
            </div>
            
            <div class="row g-4">
                <!-- Enhanced feature cards with hover effects -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="bi bi-person-check text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="text-center mb-3">Certified Trainers</h5>
                        <p class="text-muted text-center mb-3">Connect with vetted fitness professionals who create personalized plans.</p>
                        <button class="btn btn-outline-primary btn-sm d-block mx-auto" @click="showFeatureDemo('trainers')">
                            <i class="bi bi-play-circle me-2"></i>See Demo
                        </button>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up-arrow text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="text-center mb-3">Progress Analytics</h5>
                        <p class="text-muted text-center mb-3">Track your journey with detailed metrics and insights.</p>
                        <button class="btn btn-outline-primary btn-sm d-block mx-auto" @click="showFeatureDemo('analytics')">
                            <i class="bi bi-play-circle me-2"></i>See Demo
                        </button>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="bi bi-calendar-heart text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="text-center mb-3">Smart Scheduling</h5>
                        <p class="text-muted text-center mb-3">Flexible booking system that adapts to your lifestyle.</p>
                        <button class="btn btn-outline-primary btn-sm d-block mx-auto" @click="showFeatureDemo('scheduling')">
                            <i class="bi bi-play-circle me-2"></i>See Demo
                        </button>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="bi bi-chat-heart text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="text-center mb-3">24/7 Support</h5>
                        <p class="text-muted text-center mb-3">Get guidance whenever you need it with our chat system.</p>
                        <button class="btn btn-outline-primary btn-sm d-block mx-auto" @click="showFeatureDemo('support')">
                            <i class="bi bi-play-circle me-2"></i>See Demo
                        </button>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="bi bi-apple text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="text-center mb-3">Nutrition Plans</h5>
                        <p class="text-muted text-center mb-3">Personalized meal plans to complement your training.</p>
                        <button class="btn btn-outline-primary btn-sm d-block mx-auto" @click="showFeatureDemo('nutrition')">
                            <i class="bi bi-play-circle me-2"></i>See Demo
                        </button>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="bi bi-phone text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="text-center mb-3">Mobile App</h5>
                        <p class="text-muted text-center mb-3">Take your workouts anywhere with our mobile app.</p>
                        <button class="btn btn-outline-primary btn-sm d-block mx-auto" @click="showFeatureDemo('mobile')">
                            <i class="bi bi-play-circle me-2"></i>See Demo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-5">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-4 fw-bold mb-3" style="color: var(--dark);">How It Works</h2>
                <p class="lead text-muted">Get started in just 3 simple steps</p>
            </div>
            
            <div class="row g-4 align-items-center">
                <div class="col-md-4" data-aos="fade-right">
                    <div class="text-center">
                        <div class="feature-icon mx-auto mb-3" style="width: 100px; height: 100px;">
                            <span class="fw-bold text-white" style="font-size: 2rem;">1</span>
                        </div>
                        <h5>Take Assessment</h5>
                        <p class="text-muted">Complete our fitness quiz to understand your goals and fitness level</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-center">
                        <div class="feature-icon mx-auto mb-3" style="width: 100px; height: 100px;">
                            <span class="fw-bold text-white" style="font-size: 2rem;">2</span>
                        </div>
                        <h5>Match with Trainer</h5>
                        <p class="text-muted">Get paired with a certified trainer who specializes in your needs</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-left" data-aos-delay="400">
                    <div class="text-center">
                        <div class="feature-icon mx-auto mb-3" style="width: 100px; height: 100px;">
                            <span class="fw-bold text-white" style="font-size: 2rem;">3</span>
                        </div>
                        <h5>Start Training</h5>
                        <p class="text-muted">Begin your personalized workout plan and track your progress</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Stories & Testimonials -->
    <section id="testimonials" class="py-5" style="background: var(--light);">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-4 fw-bold mb-3" style="color: var(--dark);">Success Stories</h2>
                <p class="lead text-muted">Real transformations from real people</p>
            </div>
            
            <div class="row g-4" data-aos="fade-up" data-aos-delay="200">
                <div class="col-md-6 col-lg-4">
                    <div class="testimonial-card">
                        <img src="https://via.placeholder.com/80x80" class="testimonial-avatar" alt="Sarah M.">
                        <div class="stars">★★★★★</div>
                        <p class="mb-3">"Lost 30 pounds in 6 months! My trainer Sarah was amazing - she kept me motivated and created a plan that fit my busy schedule."</p>
                        <h6 class="fw-bold">Sarah M.</h6>
                        <small class="text-muted">Marketing Manager</small>
                        <div class="mt-3">
                            <span class="badge bg-success">Weight Loss: -30lbs</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="testimonial-card">
                        <img src="https://via.placeholder.com/80x80" class="testimonial-avatar" alt="Mike R.">
                        <div class="stars">★★★★★</div>
                        <p class="mb-3">"Gained 15 pounds of muscle and improved my strength by 40%. The nutrition guidance was a game-changer!"</p>
                        <h6 class="fw-bold">Mike R.</h6>
                        <small class="text-muted">Software Engineer</small>
                        <div class="mt-3">
                            <span class="badge bg-info">Muscle Gain: +15lbs</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="testimonial-card">
                        <img src="https://via.placeholder.com/80x80" class="testimonial-avatar" alt="Emma L.">
                        <div class="stars">★★★★★</div>
                        <p class="mb-3">"Completed my first marathon after working with my trainer for 8 months. Couldn't have done it without FitWell Pro!"</p>
                        <h6 class="fw-bold">Emma L.</h6>
                        <small class="text-muted">Teacher</small>
                        <div class="mt-3">
                            <span class="badge bg-warning">Marathon Finisher</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media Integration -->
            <div class="text-center mt-5">
                <h5 class="mb-4">Follow Our Community</h5>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#" class="btn btn-outline-primary rounded-circle" style="width: 50px; height: 50px;">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="btn btn-outline-primary rounded-circle" style="width: 50px; height: 50px;">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="btn btn-outline-primary rounded-circle" style="width: 50px; height: 50px;">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-outline-primary rounded-circle" style="width: 50px; height: 50px;">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Trainer Preview -->
    <section id="trainers" class="py-5">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-4 fw-bold mb-3" style="color: var(--dark);">Meet Our Expert Trainers</h2>
                <p class="lead text-muted">Certified professionals ready to guide your journey</p>
            </div>

            <!-- Trainer Filters -->
            <div class="d-flex justify-content-center mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="btn-group" role="group">
                    <button class="btn btn-outline-primary" @click="filterTrainers('all')" :class="{ 'active': trainerFilter === 'all' }">All</button>
                    <button class="btn btn-outline-primary" @click="filterTrainers('strength')" :class="{ 'active': trainerFilter === 'strength' }">Strength</button>
                    <button class="btn btn-outline-primary" @click="filterTrainers('cardio')" :class="{ 'active': trainerFilter === 'cardio' }">Cardio</button>
                    <button class="btn btn-outline-primary" @click="filterTrainers('yoga')" :class="{ 'active': trainerFilter === 'yoga' }">Yoga</button>
                    <button class="btn btn-outline-primary" @click="filterTrainers('nutrition')" :class="{ 'active': trainerFilter === 'nutrition' }">Nutrition</button>
                </div>
            </div>

            <div class="row g-4" data-aos="fade-up" data-aos-delay="400">
                <template x-for="trainer in filteredTrainers" :key="trainer.id">
                    <div class="col-md-6 col-lg-4">
                        <div class="trainer-card">
                            <div class="position-relative">
                                <img :src="trainer.image" class="trainer-avatar" :alt="trainer.name">
                                <div class="trainer-badge" x-text="trainer.specialty"></div>
                            </div>
                            <div class="p-4">
                                <h5 x-text="trainer.name" class="mb-2"></h5>
                                <p class="text-muted mb-3" x-text="trainer.bio"></p>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="stars me-2" x-html="'★'.repeat(trainer.rating) + '☆'.repeat(5-trainer.rating)"></div>
                                        <span class="text-muted" x-text="`(${trainer.reviews})`"></span>
                                    </div>
                                    <span class="badge bg-success" x-text="`${trainer.experience}+ years`"></span>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-primary-custom btn-sm flex-fill" @click="scheduleWithTrainer(trainer.id)">
                                        <i class="bi bi-calendar-plus me-2"></i>Schedule
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm" @click="viewTrainerProfile(trainer.id)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>

    <!-- Enhanced Pricing Section -->
    <section id="pricing" class="py-5" style="background: var(--light);">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-4 fw-bold mb-3" style="color: var(--dark);">Choose Your Plan</h2>
                <p class="lead text-muted">Flexible pricing to fit your lifestyle</p>
            </div>
            
            <div class="row g-4 justify-content-center" data-aos="fade-up" data-aos-delay="200">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card text-center h-100 position-relative">
                        <h5 class="mb-3">Starter</h5>
                        <div class="mb-4">
                            <span class="h2 fw-bold">$49</span>
                            <span class="text-muted">/month</span>
                        </div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>2 sessions per month</li>
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Basic progress tracking</li>
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Email support</li>
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Mobile app access</li>
                        </ul>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary">Get Started</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card text-center h-100 position-relative" style="border: 2px solid var(--primary);">
                        <div class="position-absolute top-0 start-50 translate-middle">
                            <span class="badge" style="background: var(--gradient-primary); padding: 8px 20px;">Most Popular</span>
                        </div>
                        <h5 class="mb-3 mt-3">Professional</h5>
                        <div class="mb-4">
                            <span class="h2 fw-bold">$99</span>
                            <span class="text-muted">/month</span>
                        </div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>8 sessions per month</li>
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Advanced analytics</li>
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Nutrition planning</li>
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>24/7 chat support</li>
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Custom meal plans</li>
                        </ul>
                        <a href="{{ route('register') }}" class="btn btn-primary-custom">Get Started</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card text-center h-100 position-relative">
                        <h5 class="mb-3">Elite</h5>
                        <div class="mb-4">
                            <span class="h2 fw-bold">$199</span>
                            <span class="text-muted">/month</span>
                        </div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Unlimited sessions</li>
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Premium analytics</li>
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Personal nutritionist</li>
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Priority support</li>
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Exclusive content</li>
                        </ul>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-5" style="background: var(--gradient-primary);">
        <div class="container text-center text-white" data-aos="zoom-in">
            <h2 class="display-4 fw-bold mb-3">Ready to Transform Your Life?</h2>
            <p class="lead mb-4">Join thousands who've already started their fitness journey</p>
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5">
                    <i class="bi bi-rocket-takeoff me-2"></i>Start Free Trial
                </a>
                <button class="btn btn-outline-light btn-lg px-5" @click="startQuiz">
                    <i class="bi bi-clipboard-check me-2"></i>Take Assessment
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-2 rounded-3 me-3" style="background: var(--gradient-primary);">
                            <i class="bi bi-lightning text-white"></i>
                        </div>
                        <span class="fw-bold fs-4">FitWell Pro</span>
                    </div>
                    <p class="text-light mb-3">Transform your fitness journey with personalized training and expert guidance.</p>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 40px; height: 40px;">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 40px; height: 40px;">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 40px; height: 40px;">
                            <i class="bi bi-instagram"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <h6 class="fw-bold mb-3">Features</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Personal Training</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Nutrition Plans</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Progress Tracking</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Mobile App</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-3">
                    <h6 class="fw-bold mb-3">Support</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Help Center</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Contact Us</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Privacy Policy</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold mb-3">Download Our App</h6>
                    <p class="text-light mb-3">Take your workouts anywhere with our mobile app</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#" class="btn btn-light btn-sm">
                            <i class="bi bi-apple me-2"></i>App Store
                        </a>
                        <a href="#" class="btn btn-light btn-sm">
                            <i class="bi bi-google-play me-2"></i>Google Play
                        </a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center text-muted">
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
                
                // Quiz system
                showQuiz: false,
                currentQuestion: 0,
                quizAnswers: [],
                quizCompleted: false,
                quizResult: '',
                
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
                        question: 'What is your primary fitness goal?',
                        options: [
                            { text: 'Lose weight', value: 'weight_loss' },
                            { text: 'Build muscle', value: 'muscle_gain' },
                            { text: 'Improve endurance', value: 'endurance' },
                            { text: 'General fitness', value: 'general' }
                        ]
                    },
                    {
                        question: 'How often do you currently exercise?',
                        options: [
                            { text: 'Never', value: 'never' },
                            { text: '1-2 times per week', value: 'sometimes' },
                            { text: '3-4 times per week', value: 'regularly' },
                            { text: '5+ times per week', value: 'very_active' }
                        ]
                    },
                    {
                        question: 'What type of training do you prefer?',
                        options: [
                            { text: 'Strength training', value: 'strength' },
                            { text: 'Cardio workouts', value: 'cardio' },
                            { text: 'Yoga/Flexibility', value: 'yoga' },
                            { text: 'Mixed training', value: 'mixed' }
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