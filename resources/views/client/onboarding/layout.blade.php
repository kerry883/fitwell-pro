<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Profile - FitWell Pro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Figtree', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-emerald-50 via-white to-cyan-50 min-h-screen">
    
    <!-- Progress Header -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-4xl mx-auto px-4 py-6">
            <!-- Logo & Title -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-cyan-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-heartbeat text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">FitWell Pro</h1>
                        <p class="text-sm text-gray-500">Profile Setup</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-emerald-600">{{ $step }}/7</p>
                    <p class="text-xs text-gray-500">Steps Complete</p>
                </div>
            </div>
            
            <!-- Progress Bar -->
            <div class="relative">
                <!-- Background line -->
                <div class="absolute top-5 left-0 right-0 h-1 bg-gray-200 rounded-full"></div>
                
                <!-- Progress line -->
                <div class="absolute top-5 left-0 h-1 bg-gradient-to-r from-emerald-500 to-cyan-500 rounded-full transition-all duration-500" 
                     style="width: {{ (($step - 1) / 6) * 100 }}%"></div>
                
                <!-- Steps -->
                <div class="relative flex justify-between">
                    @php
                        $steps = [
                            ['icon' => 'fa-user', 'label' => 'Personal'],
                            ['icon' => 'fa-dumbbell', 'label' => 'Fitness'],
                            ['icon' => 'fa-bullseye', 'label' => 'Goals'],
                            ['icon' => 'fa-heartbeat', 'label' => 'Medical'],
                            ['icon' => 'fa-clock', 'label' => 'Schedule'],
                            ['icon' => 'fa-box', 'label' => 'Equipment'],
                            ['icon' => 'fa-phone', 'label' => 'Contact'],
                        ];
                    @endphp
                    
                    @foreach($steps as $index => $stepInfo)
                        @php $stepNumber = $index + 1; @endphp
                        <div class="flex flex-col items-center">
                            <!-- Step Circle -->
                            <div class="w-11 h-11 rounded-full flex items-center justify-center font-semibold text-sm transition-all duration-300 shadow-md
                                @if($step > $stepNumber)
                                    bg-gradient-to-br from-emerald-500 to-emerald-600 text-white
                                @elseif($step == $stepNumber)
                                    bg-gradient-to-br from-emerald-500 to-cyan-500 text-white ring-4 ring-emerald-200 scale-110
                                @else
                                    bg-white text-gray-400 border-2 border-gray-300
                                @endif">
                                @if($step > $stepNumber)
                                    <i class="fas fa-check text-base"></i>
                                @else
                                    <i class="fas {{ $stepInfo['icon'] }} text-base"></i>
                                @endif
                            </div>
                            
                            <!-- Step Label (Hidden on mobile) -->
                            <span class="hidden sm:block text-xs font-medium mt-2
                                @if($step >= $stepNumber) text-emerald-600 @else text-gray-400 @endif">
                                {{ $stepInfo['label'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="max-w-3xl mx-auto px-4 py-8 pb-20">
        @yield('content')
    </div>
    
    <!-- Success Messages -->
    @if(session('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 5000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed bottom-6 right-6 bg-emerald-500 text-white px-6 py-4 rounded-lg shadow-xl flex items-center space-x-3 max-w-md z-50">
            <i class="fas fa-check-circle text-2xl"></i>
            <span class="font-medium">{{ session('success') }}</span>
            <button @click="show = false" class="ml-4 text-white hover:text-emerald-100">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif
    
</body>
</html>
