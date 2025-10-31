@extends('client.onboarding.layout')

@section('content')
<div class="bg-white rounded-2xl shadow-xl overflow-hidden" x-data="{ 
    selectedGoals: {{ json_encode(old('goal_templates', [])) }},
    maxGoals: 3,
    toggleGoal(goal) {
        const index = this.selectedGoals.indexOf(goal);
        if (index > -1) {
            this.selectedGoals.splice(index, 1);
        } else if (this.selectedGoals.length < this.maxGoals) {
            this.selectedGoals.push(goal);
        }
    },
    isSelected(goal) {
        return this.selectedGoals.includes(goal);
    },
    isDisabled(goal) {
        return this.selectedGoals.length >= this.maxGoals && !this.isSelected(goal);
    }
}">
    <!-- Header -->
    <div class="bg-gradient-to-r from-emerald-500 to-cyan-500 px-4 sm:px-6 md:px-8 py-4 sm:py-6 text-white">
        <h2 class="text-2xl sm:text-3xl font-bold mb-2">Your Fitness Goals</h2>
        <p class="text-sm sm:text-base text-emerald-50">Select 1-3 goals that matter most to you</p>
    </div>
    
    <!-- Info Banner -->
    <div class="bg-gradient-to-r from-blue-50 to-cyan-50 border-l-4 border-blue-500 p-4 sm:p-6 mx-4 sm:mx-6 md:mx-8 mt-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-500 text-xl sm:text-2xl"></i>
            </div>
            <div class="ml-3 sm:ml-4">
                <h4 class="font-semibold text-gray-800 mb-1 text-sm sm:text-base">Why do we ask?</h4>
                <p class="text-xs sm:text-sm text-gray-600">Your goals help us match you with the perfect fitness and nutrition programs. Choose up to 3 that align with what you want to achieve.</p>
            </div>
        </div>
    </div>
    
    <!-- Form -->
    <form method="POST" action="{{ route('client.onboarding.save', ['step' => 3]) }}" class="p-4 sm:p-6 md:p-8">
        @csrf
        
        <!-- Selection Counter -->
        <div class="mb-6 p-4 bg-gray-50 rounded-lg flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center">
                    <span class="font-bold text-white" x-text="selectedGoals.length"></span>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">Goals Selected</p>
                    <p class="text-xs text-gray-500">Select <span x-show="selectedGoals.length === 0">1-3</span><span x-show="selectedGoals.length > 0"><span x-text="maxGoals - selectedGoals.length"></span> more</span></p>
                </div>
            </div>
            <div x-show="selectedGoals.length >= maxGoals" class="text-emerald-600 font-medium text-sm">
                <i class="fas fa-check-circle mr-1"></i> Maximum reached
            </div>
        </div>
        
        <!-- Fitness Goals Section -->
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-dumbbell text-emerald-600"></i>
                </div>
                Fitness Goals
            </h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                @php
                    $fitnessGoals = [
                        'weight_loss' => ['icon' => 'fa-weight', 'color' => 'emerald'],
                        'muscle_building' => ['icon' => 'fa-dumbbell', 'color' => 'emerald'],
                        'strength' => ['icon' => 'fa-fist-raised', 'color' => 'emerald'],
                        'endurance' => ['icon' => 'fa-running', 'color' => 'emerald'],
                        'flexibility' => ['icon' => 'fa-spa', 'color' => 'emerald'],
                        'general_fitness' => ['icon' => 'fa-heartbeat', 'color' => 'emerald'],
                        'sports_performance' => ['icon' => 'fa-trophy', 'color' => 'emerald'],
                    ];
                @endphp
                
                @foreach($fitnessGoals as $key => $info)
                    @if(isset($data['goal_templates'][$key]))
                        <label class="relative cursor-pointer group"
                               :class="{ 'opacity-50': isDisabled('{{ $key }}') }">
                            <input type="checkbox" 
                                   name="goal_templates[]" 
                                   value="{{ $key }}"
                                   class="peer sr-only"
                                   @change="toggleGoal('{{ $key }}')"
                                   :checked="isSelected('{{ $key }}')"
                                   :disabled="isDisabled('{{ $key }}')">
                            
                            <div class="border-2 border-gray-200 rounded-xl p-5 transition-all duration-200 hover:border-{{ $info['color'] }}-300 hover:shadow-md peer-checked:border-{{ $info['color'] }}-500 peer-checked:bg-{{ $info['color'] }}-50 peer-checked:ring-4 peer-checked:ring-{{ $info['color'] }}-100 peer-disabled:cursor-not-allowed">
                                <div class="flex items-start space-x-4">
                                    <!-- Icon -->
                                    <div class="flex-shrink-0 w-12 h-12 bg-{{ $info['color'] }}-100 rounded-lg flex items-center justify-center peer-checked:bg-{{ $info['color'] }}-500 transition-colors">
                                        <i class="fas {{ $info['icon'] }} text-xl text-{{ $info['color'] }}-600 peer-checked:text-white"></i>
                                    </div>
                                    
                                    <!-- Content -->
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-gray-800 mb-1">{{ $data['goal_templates'][$key]['title'] }}</h4>
                                        <p class="text-sm text-gray-600 leading-relaxed">{{ $data['goal_templates'][$key]['description'] }}</p>
                                    </div>
                                    
                                    <!-- Checkmark -->
                                    <div class="flex-shrink-0 opacity-0 peer-checked:opacity-100 transition-opacity">
                                        <div class="w-6 h-6 bg-{{ $info['color'] }}-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    @endif
                @endforeach
            </div>
        </div>
        
        <!-- Nutrition Goals Section -->
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <div class="w-8 h-8 bg-cyan-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-apple-alt text-cyan-600"></i>
                </div>
                Nutrition Goals
            </h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                @php
                    $nutritionGoals = [
                        'healthy_eating' => ['icon' => 'fa-salad', 'color' => 'cyan'],
                        'meal_planning' => ['icon' => 'fa-clipboard-list', 'color' => 'cyan'],
                        'weight_gain' => ['icon' => 'fa-chart-line', 'color' => 'cyan'],
                        'body_composition' => ['icon' => 'fa-balance-scale', 'color' => 'cyan'],
                        'nutrition_knowledge' => ['icon' => 'fa-book-open', 'color' => 'cyan'],
                        'dietary_management' => ['icon' => 'fa-utensils', 'color' => 'cyan'],
                    ];
                @endphp
                
                @foreach($nutritionGoals as $key => $info)
                    @if(isset($data['goal_templates'][$key]))
                        <label class="relative cursor-pointer group"
                               :class="{ 'opacity-50': isDisabled('{{ $key }}') }">
                            <input type="checkbox" 
                                   name="goal_templates[]" 
                                   value="{{ $key }}"
                                   class="peer sr-only"
                                   @change="toggleGoal('{{ $key }}')"
                                   :checked="isSelected('{{ $key }}')"
                                   :disabled="isDisabled('{{ $key }}')">
                            
                            <div class="border-2 border-gray-200 rounded-xl p-5 transition-all duration-200 hover:border-{{ $info['color'] }}-300 hover:shadow-md peer-checked:border-{{ $info['color'] }}-500 peer-checked:bg-{{ $info['color'] }}-50 peer-checked:ring-4 peer-checked:ring-{{ $info['color'] }}-100 peer-disabled:cursor-not-allowed">
                                <div class="flex items-start space-x-4">
                                    <!-- Icon -->
                                    <div class="flex-shrink-0 w-12 h-12 bg-{{ $info['color'] }}-100 rounded-lg flex items-center justify-center peer-checked:bg-{{ $info['color'] }}-500 transition-colors">
                                        <i class="fas {{ $info['icon'] }} text-xl text-{{ $info['color'] }}-600 peer-checked:text-white"></i>
                                    </div>
                                    
                                    <!-- Content -->
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-gray-800 mb-1">{{ $data['goal_templates'][$key]['title'] }}</h4>
                                        <p class="text-sm text-gray-600 leading-relaxed">{{ $data['goal_templates'][$key]['description'] }}</p>
                                    </div>
                                    
                                    <!-- Checkmark -->
                                    <div class="flex-shrink-0 opacity-0 peer-checked:opacity-100 transition-opacity">
                                        <div class="w-6 h-6 bg-{{ $info['color'] }}-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    @endif
                @endforeach
            </div>
        </div>
        
        @error('goal_templates')
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span class="font-medium">{{ $message }}</span>
                </div>
            </div>
        @enderror
        
        <!-- Navigation -->
        <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 mt-8 pt-6 border-t border-gray-200">
            <a href="{{ route('client.onboarding.step', ['step' => 2]) }}" 
               class="group px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-all flex items-center justify-center space-x-2">
                <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                <span>Back</span>
            </a>
            
            <button type="submit" 
                    class="group px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white font-semibold rounded-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="selectedGoals.length === 0">
                <span>Continue</span>
                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </button>
        </div>
    </form>
</div>
@endsection
