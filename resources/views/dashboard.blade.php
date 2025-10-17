@php
    $title = 'Dashboard';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-6 lg:space-y-8">
    <!-- Enhanced Header with Gradient Background -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 via-emerald-600 to-cyan-600 px-6 py-8 text-white shadow-xl lg:px-8 lg:py-12">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/20 to-cyan-500/20"></div>
        <div class="relative">
            <div class="md:flex md:items-center md:justify-between">
                <div class="min-w-0 flex-1">
                    <h1 class="text-3xl font-bold leading-tight tracking-tight sm:text-4xl lg:text-5xl">
                        Welcome back, {{ Auth::user()->full_name ?? 'User' }}! 👋
                    </h1>
                    <div class="mt-3 flex flex-col space-y-2 sm:mt-4 sm:flex-row sm:items-center sm:space-x-6 sm:space-y-0">
                        <div class="flex items-center text-emerald-100">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 715.25 9h13.5a2.25 2.25 0 012.25 2.25v7.5" />
                            </svg>
                            Today is {{ date('l, F j, Y') }}
                        </div>
                        <div class="flex items-center text-emerald-100">
                            <div class="mr-2 h-2 w-2 rounded-full bg-green-400"></div>
                            Ready to achieve your fitness goals
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex flex-col space-y-3 md:ml-6 md:mt-0 md:flex-row md:space-x-3 md:space-y-0">
                    <a href="{{ route('programs.index') }}" class="group inline-flex items-center justify-center rounded-xl bg-white/20 px-6 py-3 text-sm font-semibold text-white backdrop-blur-sm transition-all duration-200 hover:bg-white/30 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-white/50">
                        <svg class="-ml-0.5 mr-2 h-5 w-5 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        Browse Programs
                    </a>
                    <a href="{{ route('client.assignments.index') }}" class="group inline-flex items-center justify-center rounded-xl bg-white/20 px-6 py-3 text-sm font-semibold text-white backdrop-blur-sm transition-all duration-200 hover:bg-white/30 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-white/50">
                        <svg class="-ml-0.5 mr-2 h-5 w-5 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        My Programs
                    </a>
                    <button class="group inline-flex items-center justify-center rounded-xl bg-white px-6 py-3 text-sm font-semibold text-emerald-600 transition-all duration-200 hover:bg-gray-50 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-white/50">
                        <svg class="-ml-0.5 mr-2 h-5 w-5 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Quick Workout
                    </button>
                </div>
            </div>
        </div>
        <!-- Decorative elements -->
        <div class="absolute -right-16 -top-16 h-32 w-32 rounded-full bg-white/10"></div>
        <div class="absolute -bottom-8 -left-8 h-24 w-24 rounded-full bg-white/5"></div>
    </div>

    <!-- Enhanced Stats Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:gap-6">
        <!-- Today's Workouts -->
        <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-lg ring-1 ring-gray-200/50 transition-all duration-300 hover:shadow-xl hover:ring-emerald-300/50 hover:-translate-y-1" 
             x-data="{ count: 0, animated: false }" 
             x-init="setTimeout(() => { count = 2; animated = true; }, 100)">
            <div class="flex items-center justify-between">
                <div class="flex-shrink-0">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-gray-900 transition-all duration-700" 
                         :class="animated ? 'transform scale-110' : ''" 
                         x-text="count"></div>
                    <div class="text-sm font-medium text-gray-500">Today's Workouts</div>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-xs text-emerald-600">
                    <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-semibold">+1 from yesterday</span>
                </div>
            </div>
            <div class="absolute -right-3 -top-3 h-8 w-8 rounded-full bg-emerald-100/50 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
        </div>

        <!-- Calories Burned -->
        <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-lg ring-1 ring-gray-200/50 transition-all duration-300 hover:shadow-xl hover:ring-orange-300/50 hover:-translate-y-1" 
             x-data="{ count: 0, animated: false }" 
             x-init="setTimeout(() => { count = 450; animated = true; }, 200)">
            <div class="flex items-center justify-between">
                <div class="flex-shrink-0">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-orange-500 to-red-500 shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 716.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                        </svg>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-gray-900 transition-all duration-700" 
                         :class="animated ? 'transform scale-110' : ''" 
                         x-text="count"></div>
                    <div class="text-sm font-medium text-gray-500">Calories Burned</div>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-xs text-orange-600">
                    <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-semibold">Excellent progress!</span>
                </div>
            </div>
            <div class="absolute -right-3 -top-3 h-8 w-8 rounded-full bg-orange-100/50 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
        </div>

        <!-- Weekly Goal Progress -->
        <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-lg ring-1 ring-gray-200/50 transition-all duration-300 hover:shadow-xl hover:ring-blue-300/50 hover:-translate-y-1" 
             x-data="{ progress: 0, animated: false }" 
             x-init="setTimeout(() => { progress = 68; animated = true; }, 300)">
            <div class="flex items-center justify-between">
                <div class="flex-shrink-0">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 713.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 713.138-3.138z" />
                        </svg>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-gray-900 transition-all duration-700" 
                         :class="animated ? 'transform scale-110' : ''">
                        <span x-text="progress"></span>%
                    </div>
                    <div class="text-sm font-medium text-gray-500">Weekly Goal</div>
                </div>
            </div>
            <div class="mt-4">
                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-blue-500 to-purple-600 rounded-full transition-all duration-1000 ease-out" 
                         :style="'width: ' + progress + '%'"></div>
                </div>
                <div class="mt-2 flex items-center text-xs text-blue-600">
                    <span class="font-semibold">2 days ahead of schedule</span>
                </div>
            </div>
            <div class="absolute -right-3 -top-3 h-8 w-8 rounded-full bg-blue-100/50 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
        </div>

        <!-- Current Streak -->
        <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-lg ring-1 ring-gray-200/50 transition-all duration-300 hover:shadow-xl hover:ring-amber-300/50 hover:-translate-y-1" 
             x-data="{ streak: 0, animated: false }" 
             x-init="setTimeout(() => { streak = 12; animated = true; }, 400)">
            <div class="flex items-center justify-between">
                <div class="flex-shrink-0">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 716.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0720 13a7.975 7.975 0 01-2.343 5.657z" />
                        </svg>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-gray-900 transition-all duration-700" 
                         :class="animated ? 'transform scale-110' : ''" 
                         x-text="streak"></div>
                    <div class="text-sm font-medium text-gray-500">Day Streak</div>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-xs text-amber-600">
                    <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-semibold">🔥 On fire!</span>
                </div>
            </div>
            <div class="absolute -right-3 -top-3 h-8 w-8 rounded-full bg-amber-100/50 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
        </div>
    </div>

    <!-- Enhanced Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
        <!-- Available Programs - Enhanced -->
        <div class="rounded-2xl bg-white shadow-lg ring-1 ring-gray-200/50 overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-50 to-cyan-50 px-6 py-4 border-b border-emerald-100/50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-500">
                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Available Programs</h3>
                    </div>
                    <a href="{{ route('programs.index') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-500 transition-colors">
                        View all →
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @php
                        $client = Auth::user()->clientProfile ?? null;
                        $availablePrograms = \App\Models\Program::public()->published()->with('trainer.user')->take(3)->get();

                        // Apply matching algorithm to get personalized recommendations
                        if ($client) {
                            $matchingService = app(\App\Services\ProgramMatchingService::class);
                            $availablePrograms = $availablePrograms->map(function ($program) use ($client, $matchingService) {
                                $matchData = $matchingService->calculateMatch($client, $program);
                                $program->match_data = $matchData;
                                $program->match_score = $matchData['total_score'];
                                return $program;
                            })->sortByDesc('match_score'); // Sort by match score for dashboard
                        }
                    @endphp
                    @forelse($availablePrograms as $program)
                    <div class="group relative overflow-hidden rounded-xl bg-gradient-to-r from-gray-50 to-gray-100 p-4 transition-all duration-300 hover:from-emerald-50 hover:to-cyan-50 hover:shadow-md
                        @if(isset($program->match_data) && $program->match_data['recommendation'] === 'excellent')
                            ring-2 ring-green-200 bg-green-50/50
                        @elseif(isset($program->match_data) && $program->match_data['recommendation'] === 'good')
                            ring-2 ring-blue-200 bg-blue-50/50
                        @endif">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 shadow-lg group-hover:from-emerald-600 group-hover:to-cyan-600 transition-all duration-300">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2">
                                        <p class="text-sm font-semibold text-gray-900 group-hover:text-emerald-700 transition-colors">{{ $program->name }}</p>
                                        @if(isset($program->match_data))
                                            @if($program->match_data['recommendation'] === 'excellent')
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    Recommended
                                                </span>
                                            @elseif($program->match_data['recommendation'] === 'good')
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                    Good Match
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500">by {{ $program->trainer->user->full_name ?? 'Trainer' }}</p>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                            @if($program->difficulty_level === 'beginner') bg-green-100 text-green-800
                                            @elseif($program->difficulty_level === 'intermediate') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($program->difficulty_level) }}
                                        </span>
                                        <span class="text-xs text-gray-500">{{ $program->duration_weeks }} weeks</span>
                                        @if(isset($program->match_data))
                                            <span class="text-xs font-medium text-gray-600">{{ round($program->match_data['total_score']) }}% match</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                @if($program->price)
                                    <p class="text-sm font-semibold text-gray-900">${{ number_format($program->price, 2) }}</p>
                                @else
                                    <p class="text-sm font-semibold text-emerald-600">Free</p>
                                @endif
                                <a href="{{ route('programs.show', $program->id) }}" class="text-xs text-emerald-600 hover:text-emerald-500 font-medium transition-colors">
                                    View Details →
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <div class="flex justify-center">
                            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="mt-4 text-sm font-medium text-gray-900">No programs available</h3>
                        <p class="mt-1 text-sm text-gray-500">Check back later for new programs.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Workouts - Enhanced -->
        <div class="rounded-2xl bg-white shadow-lg ring-1 ring-gray-200/50 overflow-hidden">
            <div class="bg-gradient-to-r from-orange-50 to-red-50 px-6 py-4 border-b border-orange-100/50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-500">
                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Recent Workouts</h3>
                    </div>
                    <a href="{{ route('workouts.index') }}" class="text-sm font-medium text-orange-600 hover:text-orange-500 transition-colors">
                        View all →
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach([
                        ['name' => 'Upper Body Strength', 'date' => 'Today', 'duration' => '45 min', 'calories' => 285, 'color' => 'emerald'],
                        ['name' => 'Morning Cardio', 'date' => 'Yesterday', 'duration' => '30 min', 'calories' => 165, 'color' => 'blue'],
                        ['name' => 'Leg Day', 'date' => '2 days ago', 'duration' => '60 min', 'calories' => 420, 'color' => 'purple']
                    ] as $workout)
                    <div class="group relative overflow-hidden rounded-xl bg-gradient-to-r from-gray-50 to-gray-100 p-4 transition-all duration-300 hover:from-orange-50 hover:to-red-50 hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-{{ $workout['color'] }}-500 to-{{ $workout['color'] }}-600 shadow-lg group-hover:from-orange-500 group-hover:to-red-500 transition-all duration-300">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 group-hover:text-orange-700 transition-colors">{{ $workout['name'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $workout['date'] }} • {{ $workout['duration'] }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-900">{{ $workout['calories'] }} cal</p>
                                <div class="flex items-center text-xs text-orange-600">
                                    <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Completed
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Today's Schedule -->
    <div class="rounded-2xl bg-white shadow-lg ring-1 ring-gray-200/50 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-purple-50 px-6 py-4 border-b border-blue-100/50">
            <div class="flex items-center space-x-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-500">
                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Today's Schedule</h3>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach([
                    ['time' => '07:00 AM', 'activity' => 'Morning Cardio', 'status' => 'completed', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                    ['time' => '12:00 PM', 'activity' => 'Protein Shake', 'status' => 'completed', 'icon' => 'M17.657 18.657A8 8 0 716.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0720 13a7.975 7.975 0 01-2.343 5.657z'],
                    ['time' => '06:00 PM', 'activity' => 'Strength Training', 'status' => 'upcoming', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                    ['time' => '08:00 PM', 'activity' => 'Post-workout meal', 'status' => 'upcoming', 'icon' => 'M17.657 18.657A8 8 0 716.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0720 13a7.975 7.975 0 01-2.343 5.657z']
                ] as $item)
                <div class="group relative overflow-hidden rounded-xl {{ $item['status'] === 'completed' ? 'bg-gradient-to-r from-emerald-50 to-green-50 ring-1 ring-emerald-200/50' : 'bg-gradient-to-r from-blue-50 to-purple-50 ring-1 ring-blue-200/50' }} p-4 transition-all duration-300 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg {{ $item['status'] === 'completed' ? 'bg-emerald-500' : 'bg-blue-500' }} shadow-lg">
                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $item['activity'] }}</p>
                                <p class="text-xs text-gray-500">{{ $item['time'] }}</p>
                            </div>
                        </div>
                        @if($item['status'] === 'completed')
                            <div class="flex items-center text-xs text-emerald-600">
                                <svg class="mr-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Done
                            </div>
                        @else
                            <div class="flex items-center text-xs text-blue-600">
                                <svg class="mr-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                Upcoming
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add any chart initialization code here if needed
    console.log('Enhanced dashboard loaded');
});
</script>
@endsection