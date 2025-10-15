@php
    $title = $program->name . ' - Program Details';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                {{ $program->name }}
            </h2>
            <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    by {{ $program->trainer->user->full_name ?? 'Trainer' }}
                </div>
            </div>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0">
            @if($program->is_enrolled)
                <span class="inline-flex items-center px-4 py-2 border border-green-300 rounded-md shadow-sm text-sm font-medium text-green-700 bg-green-50">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Enrolled
                </span>
            @elseif($program->can_enroll)
                <form method="POST" action="{{ route('programs.enroll', $program->id) }}">
                    @csrf
                    <button type="submit" class="btn-primary">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Enroll Now
                    </button>
                </form>
            @else
                <span class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-500 bg-gray-50">
                    Program Full
                </span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Program Description -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">About This Program</h3>
                <p class="text-gray-600 leading-relaxed">{{ $program->description }}</p>
            </div>

            <!-- Program Goals -->
            @if($program->goals)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Program Goals</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($program->goals as $goal)
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                                </div>
                                <span class="text-gray-700">{{ $goal }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Equipment Required -->
            @if($program->equipment_required)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Equipment Required</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($program->equipment_required as $equipment)
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <span class="text-gray-700">{{ $equipment }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Program Notes -->
            @if($program->notes)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Notes</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $program->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Program Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Program Details</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Duration</dt>
                        <dd class="text-sm text-gray-900">{{ $program->duration_weeks }} weeks</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Sessions per Week</dt>
                        <dd class="text-sm text-gray-900">{{ $program->sessions_per_week }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Difficulty Level</dt>
                        <dd class="text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($program->difficulty_level === 'beginner') bg-green-100 text-green-800
                                @elseif($program->difficulty_level === 'intermediate') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($program->difficulty_level) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Program Type</dt>
                        <dd class="text-sm text-gray-900">{{ ucfirst($program->program_type) }}</dd>
                    </div>
                    @if($program->price)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Price</dt>
                            <dd class="text-sm text-gray-900 font-semibold">${{ number_format($program->price, 2) }}</dd>
                        </div>
                    @endif
                    @if($program->max_clients)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Capacity</dt>
                            <dd class="text-sm text-gray-900">{{ $program->current_clients ?? 0 }} / {{ $program->max_clients }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Trainer Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Trainer</h3>
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-emerald-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-lg">
                                {{ substr($program->trainer->user->full_name ?? 'T', 0, 1) }}
                            </span>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">{{ $program->trainer->user->full_name ?? 'Trainer' }}</p>
                        <p class="text-sm text-gray-500">Certified Fitness Trainer</p>
                    </div>
                </div>
            </div>

            <!-- Enrollment Action -->
            @if(!$program->is_enrolled && $program->can_enroll)
                <div class="bg-emerald-50 rounded-xl border border-emerald-200 p-6">
                    <h3 class="text-lg font-semibold text-emerald-900 mb-2">Ready to Start?</h3>
                    <p class="text-emerald-700 text-sm mb-4">Enroll now and begin your fitness journey today.</p>
                    <form method="POST" action="{{ route('programs.enroll', $program->id) }}">
                        @csrf
                        <button type="submit" class="w-full btn-primary bg-emerald-600 hover:bg-emerald-700">
                            Enroll in Program
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
