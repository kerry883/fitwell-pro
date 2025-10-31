@extends('client.onboarding.layout')

@section('content')
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Header -->
    <div class="bg-gradient-to-r from-emerald-500 to-cyan-500 px-4 sm:px-6 md:px-8 py-4 sm:py-6 text-white">
        <h2 class="text-2xl sm:text-3xl font-bold mb-2">Emergency Contact</h2>
        <p class="text-sm sm:text-base text-emerald-50">One last step - who should we contact in case of emergency?</p>
    </div>
    
    <!-- Progress Indicator -->
    <div class="bg-gradient-to-r from-yellow-50 to-amber-50 border-l-4 border-yellow-500 p-4 sm:p-6 mx-4 sm:mx-6 md:mx-8 mt-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-yellow-500 rounded-full flex items-center justify-center mr-3 sm:mr-4">
                <i class="fas fa-flag-checkered text-white text-base sm:text-xl"></i>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 mb-1 text-sm sm:text-base">Almost Done!</h4>
                <p class="text-xs sm:text-sm text-gray-600">This is the final step. After this, you'll have full access to personalized programs.</p>
            </div>
        </div>
    </div>
    
    <!-- Form -->
    <form method="POST" action="{{ route('client.onboarding.save', ['step' => 7]) }}" class="p-4 sm:p-6 md:p-8">
        @csrf
        
        <div class="space-y-6">
            
            <!-- Emergency Contact Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-user text-emerald-500 mr-2"></i>
                    Contact Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="emergency_contact_name" 
                       value="{{ old('emergency_contact_name', $client->emergency_contact_name) }}"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition-all outline-none @error('emergency_contact_name') border-red-500 @enderror"
                       placeholder="e.g., John Smith"
                       required>
                @error('emergency_contact_name')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                    </p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Full name of your emergency contact</p>
            </div>
            
            <!-- Emergency Contact Phone -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-phone text-emerald-500 mr-2"></i>
                    Phone Number <span class="text-red-500">*</span>
                </label>
                <input type="tel" 
                       name="emergency_contact_phone" 
                       value="{{ old('emergency_contact_phone', $client->emergency_contact_phone) }}"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition-all outline-none @error('emergency_contact_phone') border-red-500 @enderror"
                       placeholder="e.g., +254 712 345 678"
                       required>
                @error('emergency_contact_phone')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                    </p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">A working phone number where they can be reached</p>
            </div>
            
            <!-- Relationship -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-heart text-emerald-500 mr-2"></i>
                    Relationship <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="emergency_contact_relationship" 
                       value="{{ old('emergency_contact_relationship', $client->emergency_contact_relationship) }}"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition-all outline-none @error('emergency_contact_relationship') border-red-500 @enderror"
                       placeholder="e.g., Spouse, Parent, Sibling, Friend"
                       required>
                @error('emergency_contact_relationship')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                    </p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">How is this person related to you?</p>
            </div>
            
            <!-- Safety Notice -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-shield-alt text-white text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-2">Your Safety Matters</h4>
                        <p class="text-sm text-gray-600 leading-relaxed">This information will only be used in case of a medical emergency during your training. We take your privacy and safety very seriously.</p>
                    </div>
                </div>
            </div>
            
            <!-- Completion Preview -->
            <div class="bg-gradient-to-br from-emerald-50 to-cyan-50 border-2 border-emerald-200 rounded-xl p-6 mt-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-cyan-500 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-rocket text-white text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg mb-1">Ready to Get Started!</h4>
                            <p class="text-sm text-gray-600">Complete your profile and unlock personalized fitness programs</p>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="text-center px-6 py-3 bg-white rounded-lg shadow-md">
                            <p class="text-3xl font-bold text-emerald-600">100%</p>
                            <p class="text-xs text-gray-500 font-medium">Complete</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Navigation -->
        <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 mt-8 pt-6 border-t border-gray-200">
            <a href="{{ route('client.onboarding.step', ['step' => 6]) }}" 
               class="group px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-all flex items-center justify-center space-x-2">
                <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                <span>Back</span>
            </a>
            
            <button type="submit" 
                    class="group px-8 sm:px-10 py-4 sm:py-5 bg-gradient-to-r from-emerald-500 via-green-500 to-cyan-500 text-white font-bold text-base sm:text-lg rounded-xl hover:shadow-2xl transform hover:-translate-y-1 hover:scale-105 transition-all duration-300 flex items-center justify-center space-x-2 sm:space-x-3 animate-pulse hover:animate-none">
                <span>Complete Setup</span>
                <i class="fas fa-check-circle group-hover:rotate-12 transition-transform text-xl sm:text-2xl"></i>
            </button>
        </div>
    </form>
</div>
@endsection
