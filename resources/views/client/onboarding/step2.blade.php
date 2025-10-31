@extends('client.onboarding.layout')

@section('content')
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Header -->
    <div class="bg-gradient-to-r from-emerald-500 to-cyan-500 px-4 sm:px-6 md:px-8 py-4 sm:py-6 text-white">
        <h2 class="text-2xl sm:text-3xl font-bold mb-2">Fitness Level & Schedule</h2>
        <p class="text-sm sm:text-base text-emerald-50">Tell us about your fitness experience and availability</p>
    </div>
    
    <!-- Form -->
    <form method="POST" action="{{ route('client.onboarding.save', ['step' => 2]) }}" class="p-4 sm:p-6 md:p-8">
        @csrf
        
        <div class="space-y-6">
            
            <!-- Experience Level -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <i class="fas fa-chart-line text-emerald-500 mr-2"></i>
                    What's your fitness experience level?
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @php
                        $levels = [
                            'beginner' => [
                                'icon' => 'fa-seedling',
                                'label' => 'Beginner',
                                'desc' => 'New to fitness'
                            ],
                            'intermediate' => [
                                'icon' => 'fa-running',
                                'label' => 'Intermediate',
                                'desc' => '6+ months experience'
                            ],
                            'advanced' => [
                                'icon' => 'fa-medal',
                                'label' => 'Advanced',
                                'desc' => '2+ years experience'
                            ],
                        ];
                    @endphp
                    
                    @foreach($levels as $value => $info)
                        <label class="relative cursor-pointer">
                            <input type="radio" 
                                   name="experience_level" 
                                   value="{{ $value }}" 
                                   {{ old('experience_level', $user->fitness_level ?? $client->experience_level) == $value ? 'checked' : '' }}
                                   class="peer sr-only"
                                   required>
                            <div class="border-2 border-gray-200 rounded-xl p-6 text-center transition-all hover:border-emerald-300 hover:shadow-md peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:ring-4 peer-checked:ring-emerald-100">
                                <i class="fas {{ $info['icon'] }} text-4xl mb-3 text-gray-400 transition-colors peer-checked:text-emerald-500"></i>
                                <h4 class="font-bold text-gray-800 mb-1">{{ $info['label'] }}</h4>
                                <p class="text-xs text-gray-500">{{ $info['desc'] }}</p>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('experience_level')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                    </p>
                @enderror
            </div>
            
            <!-- Available Days Per Week -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <i class="fas fa-calendar-week text-emerald-500 mr-2"></i>
                    How many days per week can you work out?
                </label>
                <div class="grid grid-cols-4 sm:grid-cols-7 gap-2 sm:gap-3">
                    @for($i = 1; $i <= 7; $i++)
                        <label class="relative cursor-pointer">
                            <input type="radio" 
                                   name="available_days_per_week" 
                                   value="{{ $i }}" 
                                   {{ old('available_days_per_week', $client->available_days_per_week) == $i ? 'checked' : '' }}
                                   class="peer sr-only"
                                   required>
                            <div class="aspect-square border-2 border-gray-200 rounded-lg flex items-center justify-center font-bold text-base sm:text-lg transition-all hover:border-emerald-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 peer-checked:text-white peer-checked:scale-110 peer-checked:shadow-lg">
                                {{ $i }}
                            </div>
                        </label>
                    @endfor
                </div>
                @error('available_days_per_week')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                    </p>
                @enderror
                <p class="mt-2 text-xs text-gray-500">Select the number of days you can commit to training</p>
            </div>
            
            <!-- Workout Duration Preference -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <i class="fas fa-clock text-emerald-500 mr-2"></i>
                    Preferred workout duration (minutes)
                </label>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                    @php
                        $durations = [
                            15 => '15 min',
                            30 => '30 min',
                            45 => '45 min',
                            60 => '60 min',
                            90 => '90 min',
                            120 => '2 hours',
                        ];
                    @endphp
                    
                    @foreach($durations as $value => $label)
                        <label class="relative cursor-pointer">
                            <input type="radio" 
                                   name="workout_duration_preference" 
                                   value="{{ $value }}" 
                                   {{ old('workout_duration_preference', $client->workout_duration_preference) == $value ? 'checked' : '' }}
                                   class="peer sr-only"
                                   required>
                            <div class="border-2 border-gray-200 rounded-lg p-4 text-center font-medium transition-all hover:border-emerald-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700">
                                {{ $label }}
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('workout_duration_preference')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                    </p>
                @enderror
            </div>
            
            <!-- Fitness History (Optional) -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-file-alt text-emerald-500 mr-2"></i>
                    Fitness History <span class="text-gray-400 font-normal">(Optional)</span>
                </label>
                <textarea name="fitness_history" 
                          rows="4"
                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition-all outline-none resize-none"
                          placeholder="Tell us about your fitness journey... any sports, activities, or training you've done before">{{ old('fitness_history', $client->fitness_history) }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Share any relevant fitness background (optional)</p>
            </div>
            
        </div>
        
        <!-- Navigation -->
        <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 mt-8 pt-6 border-t border-gray-200">
            <a href="{{ route('client.onboarding.step', ['step' => 1]) }}" 
               class="group px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-all flex items-center justify-center space-x-2">
                <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                <span>Back</span>
            </a>
            
            <button type="submit" 
                    class="group px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white font-semibold rounded-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center space-x-2">
                <span>Continue</span>
                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </button>
        </div>
    </form>
</div>
@endsection
