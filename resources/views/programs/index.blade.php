@php
    $title = 'Available Programs';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Available Programs
            </h2>
            <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    Discover and enroll in fitness programs
                </div>
            </div>
        </div>
    </div>

    <!-- Programs Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($programs as $program)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-200">
                <div class="p-6">
                    <!-- Program Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $program->name }}</h3>
                            <p class="text-sm text-gray-600">by {{ $program->trainer->user->full_name ?? 'Trainer' }}</p>
                        </div>
                        <div class="flex flex-col items-end space-y-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($program->difficulty_level === 'beginner') bg-green-100 text-green-800
                                @elseif($program->difficulty_level === 'intermediate') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($program->difficulty_level) }}
                            </span>
                            @if($program->price)
                                <span class="text-sm font-medium text-gray-900">${{ number_format($program->price, 2) }}</span>
                            @else
                                <span class="text-sm font-medium text-green-600">Free</span>
                            @endif
                        </div>
                    </div>

                    <!-- Program Details -->
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit($program->description, 120) }}</p>

                    <!-- Program Stats -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="text-center">
                            <div class="text-lg font-semibold text-gray-900">{{ $program->duration_weeks }}</div>
                            <div class="text-xs text-gray-500">Weeks</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-semibold text-gray-900">{{ $program->sessions_per_week }}</div>
                            <div class="text-xs text-gray-500">Sessions/Week</div>
                        </div>
                    </div>

                    <!-- Program Goals -->
                    @if($program->goals)
                        <div class="mb-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach(array_slice($program->goals, 0, 2) as $goal)
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700">
                                        {{ $goal }}
                                    </span>
                                @endforeach
                                @if(count($program->goals) > 2)
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-50 text-gray-600">
                                        +{{ count($program->goals) - 2 }} more
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex space-x-2">
                        <a href="{{ route('programs.show', $program->id) }}"
                           class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                            View Details
                        </a>
                        @if($program->is_enrolled)
                            <span class="inline-flex items-center px-4 py-2 border border-green-300 rounded-md shadow-sm text-sm font-medium text-green-700 bg-green-50">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Enrolled
                            </span>
                        @elseif($program->can_enroll)
                            <form method="POST" action="{{ route('programs.enroll', $program->id) }}" class="flex-1">
                                @csrf
                                <button type="submit"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                    Enroll Now
                                </button>
                            </form>
                        @else
                            <span class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-500 bg-gray-50">
                                Full
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No programs available</h3>
                    <p class="mt-1 text-sm text-gray-500">Check back later for new programs.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
