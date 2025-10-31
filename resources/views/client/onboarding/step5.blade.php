@extends('client.onboarding.layout')

@section('content')
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-500 to-indigo-500 px-4 sm:px-6 md:px-8 py-4 sm:py-6 text-white">
        <h2 class="text-2xl sm:text-3xl font-bold mb-2">Workout Preferences</h2>
        <p class="text-sm sm:text-base text-purple-50">Help us tailor your workouts to your preferences</p>
    </div>
    
    <!-- Form -->
    <form method="POST" action="{{ route('client.onboarding.save', ['step' => 5]) }}" class="p-4 sm:p-6 md:p-8">
        @csrf
        
        <div class="space-y-8">
            
            <!-- Preferred Workout Types -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-4">
                    <i class="fas fa-fire text-purple-500 mr-2"></i>
                    What types of workouts do you enjoy? <span class="text-gray-400 font-normal">(Select at least 1)</span>
                </label>
                
                @php
                    $workoutTypes = [
                        'strength' => ['icon' => 'fa-dumbbell', 'label' => 'Strength Training', 'desc' => 'Weight lifting & resistance exercises', 'color' => 'red'],
                        'cardio' => ['icon' => 'fa-running', 'label' => 'Cardio', 'desc' => 'Running, cycling, HIIT', 'color' => 'orange'],
                        'flexibility' => ['icon' => 'fa-spa', 'label' => 'Flexibility', 'desc' => 'Yoga, stretching, mobility', 'color' => 'green'],
                        'sports' => ['icon' => 'fa-basketball-ball', 'label' => 'Sports', 'desc' => 'Basketball, soccer, tennis', 'color' => 'blue'],
                        'weight_loss' => ['icon' => 'fa-weight', 'label' => 'Weight Loss', 'desc' => 'Fat burning workouts', 'color' => 'yellow'],
                        'muscle_gain' => ['icon' => 'fa-medal', 'label' => 'Muscle Gain', 'desc' => 'Hypertrophy training', 'color' => 'purple'],
                        'endurance' => ['icon' => 'fa-heartbeat', 'label' => 'Endurance', 'desc' => 'Long-distance training', 'color' => 'pink'],
                        'general_fitness' => ['icon' => 'fa-star', 'label' => 'General Fitness', 'desc' => 'Overall health & wellness', 'color' => 'indigo'],
                    ];
                    $oldTypes = old('preferred_workout_types', is_array($client->preferred_workout_types) ? $client->preferred_workout_types : []);
                @endphp
                
                <div class="grid md:grid-cols-2 gap-4">
                    @foreach($workoutTypes as $value => $info)
                        <label class="relative cursor-pointer group">
                            <input type="checkbox" 
                                   name="preferred_workout_types[]" 
                                   value="{{ $value }}"
                                   {{ in_array($value, $oldTypes) ? 'checked' : '' }}
                                   class="peer sr-only">
                            
                            <div class="border-2 border-gray-200 rounded-xl p-5 transition-all duration-200 hover:border-purple-300 hover:shadow-md peer-checked:border-purple-500 peer-checked:bg-gradient-to-br peer-checked:from-purple-50 peer-checked:to-transparent peer-checked:ring-4 peer-checked:ring-purple-100">
                                <div class="flex items-start space-x-4">
                                    <!-- Icon -->
                                    <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-{{ $info['color'] }}-400 to-{{ $info['color'] }}-600 rounded-xl flex items-center justify-center shadow-md">
                                        <i class="fas {{ $info['icon'] }} text-2xl text-white"></i>
                                    </div>
                                    
                                    <!-- Content -->
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-bold text-gray-800 mb-1">{{ $info['label'] }}</h4>
                                        <p class="text-sm text-gray-600">{{ $info['desc'] }}</p>
                                    </div>
                                    
                                    <!-- Checkmark -->
                                    <div class="flex-shrink-0 opacity-0 peer-checked:opacity-100 transition-opacity">
                                        <div class="w-7 h-7 bg-purple-500 rounded-full flex items-center justify-center shadow-md">
                                            <i class="fas fa-check text-white text-sm"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
                
                @error('preferred_workout_types')
                    <p class="mt-3 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                    </p>
                @enderror
            </div>
            
            <!-- Preferred Workout Time -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-4">
                    <i class="fas fa-clock text-purple-500 mr-2"></i>
                    When do you prefer to work out? <span class="text-gray-400 font-normal">(Optional)</span>
                </label>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @php
                        $timeSlots = [
                            '06:00' => ['icon' => 'fa-sunrise', 'label' => 'Early Morning', 'time' => '6:00 AM'],
                            '09:00' => ['icon' => 'fa-sun', 'label' => 'Morning', 'time' => '9:00 AM'],
                            '12:00' => ['icon' => 'fa-cloud-sun', 'label' => 'Midday', 'time' => '12:00 PM'],
                            '15:00' => ['icon' => 'fa-cloud-sun', 'label' => 'Afternoon', 'time' => '3:00 PM'],
                            '18:00' => ['icon' => 'fa-sunset', 'label' => 'Evening', 'time' => '6:00 PM'],
                            '21:00' => ['icon' => 'fa-moon', 'label' => 'Night', 'time' => '9:00 PM'],
                        ];
                    @endphp
                    
                    @foreach($timeSlots as $value => $info)
                        <label class="relative cursor-pointer">
                            <input type="radio" 
                                   name="preferred_workout_time" 
                                   value="{{ $value }}"
                                   {{ old('preferred_workout_time', $client->preferred_workout_time) == $value ? 'checked' : '' }}
                                   class="peer sr-only">
                            
                            <div class="border-2 border-gray-200 rounded-xl p-4 text-center transition-all hover:border-purple-300 peer-checked:border-purple-500 peer-checked:bg-purple-50 peer-checked:ring-4 peer-checked:ring-purple-100">
                                <i class="fas {{ $info['icon'] }} text-3xl mb-2 text-gray-400 peer-checked:text-purple-500"></i>
                                <p class="font-semibold text-gray-800 text-sm mb-1">{{ $info['label'] }}</p>
                                <p class="text-xs text-gray-500">{{ $info['time'] }}</p>
                            </div>
                        </label>
                    @endforeach
                </div>
                
                <p class="mt-3 text-xs text-gray-500">
                    <i class="fas fa-lightbulb text-yellow-500 mr-1"></i>
                    This helps us schedule notifications and reminders
                </p>
            </div>
            
        </div>
        
        <!-- Navigation -->
        <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 mt-8 pt-6 border-t border-gray-200">
            <a href="{{ route('client.onboarding.step', ['step' => 4]) }}" 
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
