@extends('client.onboarding.layout')

@section('content')
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Header -->
    <div class="bg-gradient-to-r from-emerald-500 to-cyan-500 px-4 sm:px-6 md:px-8 py-4 sm:py-6 text-white">
        <h2 class="text-2xl sm:text-3xl font-bold mb-2">Personal Information</h2>
        <p class="text-sm sm:text-base text-emerald-50">Let's start with some basic information about you</p>
    </div>
    
    <!-- Form -->
    <form method="POST" action="{{ route('client.onboarding.save', ['step' => 1]) }}" class="p-4 sm:p-6 md:p-8">
        @csrf
        
        <div class="space-y-6">
            
            <!-- Height -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-arrows-alt-v text-emerald-500 mr-2"></i>
                    Height (cm)
                </label>
                <div class="relative">
                    <input type="number" 
                           name="height" 
                           value="{{ old('height', $user->height ?? $client->height) }}"
                           min="100" 
                           max="250" 
                           step="0.1"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition-all outline-none @error('height') border-red-500 @enderror"
                           placeholder="e.g., 175"
                           required>
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 font-medium">cm</span>
                </div>
                @error('height')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                    </p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Enter your height in centimeters</p>
            </div>
            
            <!-- Weight -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-weight text-emerald-500 mr-2"></i>
                    Weight (kg)
                </label>
                <div class="relative">
                    <input type="number" 
                           name="weight" 
                           value="{{ old('weight', $user->weight ?? $client->weight) }}"
                           min="30" 
                           max="300" 
                           step="0.1"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition-all outline-none @error('weight') border-red-500 @enderror"
                           placeholder="e.g., 70"
                           required>
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 font-medium">kg</span>
                </div>
                @error('weight')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                    </p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Enter your current weight in kilograms</p>
            </div>
            
            <!-- Age -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-birthday-cake text-emerald-500 mr-2"></i>
                    Age
                </label>
                <input type="number" 
                       name="age" 
                       value="{{ old('age', $user->age ?? $client->age) }}"
                       min="13" 
                       max="100"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition-all outline-none @error('age') border-red-500 @enderror"
                       placeholder="e.g., 28"
                       required>
                @error('age')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                    </p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">You must be at least 13 years old</p>
            </div>
            
            <!-- Gender -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-venus-mars text-emerald-500 mr-2"></i>
                    Gender
                </label>
                <div class="grid grid-cols-3 gap-3 sm:gap-4">
                    @foreach(['male' => ['icon' => 'fa-mars', 'label' => 'Male'], 
                              'female' => ['icon' => 'fa-venus', 'label' => 'Female'], 
                              'other' => ['icon' => 'fa-genderless', 'label' => 'Other']] as $value => $info)
                        <label class="relative cursor-pointer">
                            <input type="radio" 
                                   name="gender" 
                                   value="{{ $value }}" 
                                   {{ old('gender', $user->gender ?? $client->gender) == $value ? 'checked' : '' }}
                                   class="peer sr-only"
                                   required>
                            <div class="border-2 border-gray-200 rounded-lg p-3 sm:p-4 text-center transition-all hover:border-emerald-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:ring-4 peer-checked:ring-emerald-100">
                                <i class="fas {{ $info['icon'] }} text-xl sm:text-2xl mb-1 sm:mb-2 text-gray-400 peer-checked:text-emerald-500"></i>
                                <p class="font-medium text-sm sm:text-base text-gray-700">{{ $info['label'] }}</p>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('gender')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                    </p>
                @enderror
            </div>
            
        </div>
        
        <!-- Navigation -->
        <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 mt-8 pt-6 border-t border-gray-200">
            <div class="text-sm text-gray-500 text-center sm:text-left">
                <i class="fas fa-info-circle mr-1"></i>
                <span class="hidden sm:inline">This information helps us personalize your experience</span>
                <span class="sm:hidden">Personalize your experience</span>
            </div>
            
            <button type="submit" 
                    class="group px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white font-semibold rounded-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center space-x-2">
                <span>Continue</span>
                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </button>
        </div>
    </form>
</div>
@endsection
