@extends('client.onboarding.layout')

@section('content')
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Header -->
    <div class="bg-gradient-to-r from-cyan-500 to-blue-500 px-4 sm:px-6 md:px-8 py-4 sm:py-6 text-white">
        <h2 class="text-2xl sm:text-3xl font-bold mb-2">Equipment Access</h2>
        <p class="text-sm sm:text-base text-cyan-50">What equipment do you have access to?</p>
    </div>
    
    <!-- Info Banner -->
    <div class="bg-gradient-to-r from-blue-50 to-cyan-50 border-l-4 border-blue-500 p-4 sm:p-6 mx-4 sm:mx-6 md:mx-8 mt-6">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-500 text-xl sm:text-2xl mr-2 sm:mr-3"></i>
            <div>
                <h4 class="font-semibold text-gray-800 mb-1 text-sm sm:text-base">Why do we ask?</h4>
                <p class="text-xs sm:text-sm text-gray-600">We'll match you with programs that use equipment you have available. This ensures you can complete every workout successfully.</p>
            </div>
        </div>
    </div>
    
    <!-- Form -->
    <form method="POST" action="{{ route('client.onboarding.save', ['step' => 6]) }}" class="p-4 sm:p-6 md:p-8">
        @csrf
        
        <div class="space-y-6">
            
            <label class="block text-sm font-semibold text-gray-700 mb-4">
                <i class="fas fa-box text-cyan-500 mr-2"></i>
                Select all equipment you have access to <span class="text-gray-400 font-normal">(Select at least 1)</span>
            </label>
            
            @php
                $equipment = [
                    'dumbbells' => ['icon' => 'fa-dumbbell', 'label' => 'Dumbbells', 'color' => 'blue'],
                    'barbell' => ['icon' => 'fa-weight-hanging', 'label' => 'Barbell', 'color' => 'indigo'],
                    'resistance_bands' => ['icon' => 'fa-minus', 'label' => 'Resistance Bands', 'color' => 'pink'],
                    'bodyweight' => ['icon' => 'fa-running', 'label' => 'Bodyweight Only', 'color' => 'emerald'],
                    'kettlebell' => ['icon' => 'fa-weight', 'label' => 'Kettlebell', 'color' => 'orange'],
                    'pull_up_bar' => ['icon' => 'fa-bars', 'label' => 'Pull-up Bar', 'color' => 'red'],
                    'yoga_mat' => ['icon' => 'fa-spa', 'label' => 'Yoga Mat', 'color' => 'green'],
                    'treadmill' => ['icon' => 'fa-shoe-prints', 'label' => 'Treadmill', 'color' => 'gray'],
                    'stationary_bike' => ['icon' => 'fa-biking', 'label' => 'Stationary Bike', 'color' => 'yellow'],
                    'rowing_machine' => ['icon' => 'fa-water', 'label' => 'Rowing Machine', 'color' => 'cyan'],
                    'none' => ['icon' => 'fa-times-circle', 'label' => 'No Equipment', 'color' => 'slate'],
                ];
                $oldEquipment = old('equipment_access', is_array($client->equipment_access) ? $client->equipment_access : []);
            @endphp
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($equipment as $value => $info)
                    <label class="relative cursor-pointer group">
                        <input type="checkbox" 
                               name="equipment_access[]" 
                               value="{{ $value }}"
                               {{ in_array($value, $oldEquipment) ? 'checked' : '' }}
                               class="peer sr-only">
                        
                        <div class="border-2 border-gray-200 rounded-xl p-4 transition-all duration-200 hover:border-cyan-300 hover:shadow-lg hover:-translate-y-1 peer-checked:border-cyan-500 peer-checked:bg-gradient-to-br peer-checked:from-cyan-50 peer-checked:to-blue-50 peer-checked:ring-4 peer-checked:ring-cyan-100 h-full">
                            <div class="flex flex-col items-center text-center space-y-3">
                                <!-- Icon Container -->
                                <div class="w-16 h-16 bg-gradient-to-br from-{{ $info['color'] }}-100 to-{{ $info['color'] }}-200 rounded-full flex items-center justify-center shadow-md peer-checked:from-cyan-400 peer-checked:to-blue-500 transition-all">
                                    <i class="fas {{ $info['icon'] }} text-2xl text-{{ $info['color'] }}-600 peer-checked:text-white"></i>
                                </div>
                                
                                <!-- Label -->
                                <p class="font-semibold text-gray-800 text-sm leading-tight">{{ $info['label'] }}</p>
                                
                                <!-- Checkmark Badge -->
                                <div class="absolute top-2 right-2 w-6 h-6 bg-cyan-500 rounded-full flex items-center justify-center shadow-md opacity-0 peer-checked:opacity-100 transition-opacity">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>
            
            @error('equipment_access')
                <div class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span class="font-medium">{{ $message }}</span>
                    </div>
                </div>
            @enderror
            
            <!-- Helpful Tips -->
            <div class="grid md:grid-cols-2 gap-4 mt-8">
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-lightbulb text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 text-sm mb-1">Tip: Home Workouts</h4>
                            <p class="text-xs text-gray-600">Select "Bodyweight Only" if you prefer to work out at home without equipment</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-building text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 text-sm mb-1">Gym Members</h4>
                            <p class="text-xs text-gray-600">Select all equipment available at your gym for maximum program options</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Navigation -->
        <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 mt-8 pt-6 border-t border-gray-200">
            <a href="{{ route('client.onboarding.step', ['step' => 5]) }}" 
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
