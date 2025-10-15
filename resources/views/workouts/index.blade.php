@php
    $title = 'Workouts';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Workouts</h1>
            <p class="mt-2 text-sm text-gray-700">Manage your fitness routines and track your progress</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href="{{ route('workouts.create') }}" class="btn-primary">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                New Workout
            </a>
        </div>
    </div>

    <!-- Filter tabs -->
    <div class="border-b border-gray-200" x-data="{ activeTab: 'all' }">
        <nav class="-mb-px flex space-x-8">
            <button @click="activeTab = 'all'" 
                    :class="activeTab === 'all' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                    class="whitespace-nowrap border-b-2 py-2 px-1 text-sm font-medium">
                All Workouts
            </button>
            <button @click="activeTab = 'strength'" 
                    :class="activeTab === 'strength' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                    class="whitespace-nowrap border-b-2 py-2 px-1 text-sm font-medium">
                Strength
            </button>
            <button @click="activeTab = 'cardio'" 
                    :class="activeTab === 'cardio' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                    class="whitespace-nowrap border-b-2 py-2 px-1 text-sm font-medium">
                Cardio
            </button>
            <button @click="activeTab = 'flexibility'" 
                    :class="activeTab === 'flexibility' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                    class="whitespace-nowrap border-b-2 py-2 px-1 text-sm font-medium">
                Flexibility
            </button>
        </nav>
    </div>

    <!-- Workout cards grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($workouts as $workout)
        <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-100 hover:shadow-lg transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        @if($workout['category'] === 'Strength')
                        <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        @elseif($workout['category'] === 'Cardio')
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        @else
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        @endif
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">{{ $workout['category'] }}</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $workout['name'] }}</dd>
                        </dl>
                    </div>
                </div>
                
                <div class="mt-5 grid grid-cols-2 gap-4 text-sm text-gray-600">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $workout['duration'] }} min
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                        </svg>
                        {{ $workout['calories'] }} cal
                    </div>
                </div>
                
                <div class="mt-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        @if($workout['difficulty'] === 'Beginner') bg-green-100 text-green-800 
                        @elseif($workout['difficulty'] === 'Intermediate') bg-yellow-100 text-yellow-800 
                        @else bg-red-100 text-red-800 @endif">
                        {{ $workout['difficulty'] }}
                    </span>
                </div>
                
                <div class="mt-4 flex justify-between">
                    <a href="{{ route('workouts.show', $workout['id']) }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-500">
                        View Details
                    </a>
                    <div class="flex space-x-2">
                        <a href="{{ route('workouts.edit', $workout['id']) }}" class="text-sm text-gray-500 hover:text-gray-700">
                            Edit
                        </a>
                        <button class="text-sm text-red-500 hover:text-red-700" 
                                onclick="if(confirm('Are you sure?')) { document.getElementById('delete-form-{{ $workout['id'] }}').submit(); }">
                            Delete
                        </button>
                        <form id="delete-form-{{ $workout['id'] }}" action="{{ route('workouts.destroy', $workout['id']) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if(empty($workouts))
    <div class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No workouts</h3>
        <p class="mt-1 text-sm text-gray-500">Get started by creating your first workout.</p>
        <div class="mt-6">
            <a href="{{ route('workouts.create') }}" class="btn-primary">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                New Workout
            </a>
        </div>
    </div>
    @endif
</div>
@endsection