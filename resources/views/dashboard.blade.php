@php
    $title = 'Dashboard';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Welcome back, {{ Auth::user()->full_name ?? 'User' }}!
            </h2>
            <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    Today is {{ date('l, F j, Y') }}
                </div>
            </div>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0">
            <a href="{{ route('programs.index') }}" class="btn-primary">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Browse Programs
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Today's Workouts -->
        <div class="metric-card" x-data="{ count: 0 }" x-init="setTimeout(() => count = 2, 100)">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Today's Workouts</dt>
                        <dd class="text-lg font-medium text-gray-900" x-text="count"></dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Calories Burned -->
        <div class="metric-card" x-data="{ count: 0 }" x-init="setTimeout(() => count = 450, 200)">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Calories Burned</dt>
                        <dd class="text-lg font-medium text-gray-900" x-text="count"></dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Weekly Goal Progress -->
        <div class="metric-card" x-data="{ progress: 0 }" x-init="setTimeout(() => progress = 68, 300)">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Weekly Goal</dt>
                        <dd class="text-lg font-medium text-gray-900"><span x-text="progress"></span>%</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Current Streak -->
        <div class="metric-card" x-data="{ streak: 0 }" x-init="setTimeout(() => streak = 12, 400)">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Current Streak</dt>
                        <dd class="text-lg font-medium text-gray-900"><span x-text="streak"></span> days</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Available Programs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Available Programs</h3>
                <a href="{{ route('programs.index') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-500">
                    View all
                </a>
            </div>
            <div class="space-y-4">
                @php
                    $availablePrograms = \App\Models\Program::public()->published()->with('trainer.user')->take(3)->get();
                @endphp
                @forelse($availablePrograms as $program)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $program->name }}</p>
                            <p class="text-xs text-gray-500">by {{ $program->trainer->user->full_name ?? 'Trainer' }}</p>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                    @if($program->difficulty_level === 'beginner') bg-green-100 text-green-800
                                    @elseif($program->difficulty_level === 'intermediate') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($program->difficulty_level) }}
                                </span>
                                <span class="text-xs text-gray-500">{{ $program->duration_weeks }} weeks</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        @if($program->price)
                            <p class="text-sm font-medium text-gray-900">${{ number_format($program->price, 2) }}</p>
                        @else
                            <p class="text-sm font-medium text-green-600">Free</p>
                        @endif
                        <a href="{{ route('programs.show', $program->id) }}" class="text-xs text-emerald-600 hover:text-emerald-500 font-medium">
                            View Details →
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No programs available</h3>
                    <p class="mt-1 text-sm text-gray-500">Check back later for new programs.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Workouts -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Recent Workouts</h3>
                <a href="{{ route('workouts.index') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-500">
                    View all
                </a>
            </div>
            <div class="space-y-4">
                @foreach([
                    ['name' => 'Upper Body Strength', 'date' => 'Today', 'duration' => '45 min', 'calories' => 285],
                    ['name' => 'Morning Cardio', 'date' => 'Yesterday', 'duration' => '30 min', 'calories' => 165],
                    ['name' => 'Leg Day', 'date' => '2 days ago', 'duration' => '60 min', 'calories' => 420]
                ] as $workout)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $workout['name'] }}</p>
                            <p class="text-xs text-gray-500">{{ $workout['date'] }} • {{ $workout['duration'] }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">{{ $workout['calories'] }} cal</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Today's Schedule -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Today's Schedule</h3>
        <div class="space-y-3">
            @foreach([
                ['time' => '07:00 AM', 'activity' => 'Morning Cardio', 'status' => 'completed'],
                ['time' => '12:00 PM', 'activity' => 'Protein Shake', 'status' => 'completed'],
                ['time' => '06:00 PM', 'activity' => 'Strength Training', 'status' => 'upcoming'],
                ['time' => '08:00 PM', 'activity' => 'Post-workout meal', 'status' => 'upcoming']
            ] as $item)
            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg {{ $item['status'] === 'completed' ? 'bg-green-50 border-green-200' : 'bg-white' }}">
                <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 rounded-full {{ $item['status'] === 'completed' ? 'bg-green-500' : 'bg-gray-400' }}"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $item['activity'] }}</p>
                        <p class="text-xs text-gray-500">{{ $item['time'] }}</p>
                    </div>
                </div>
                @if($item['status'] === 'completed')
                    <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('progressChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Calories Burned',
                data: [300, 450, 320, 580, 420, 380, 450],
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>
@endsection