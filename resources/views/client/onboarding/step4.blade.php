@extends('client.onboarding.layout')

@section('content')
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Header -->
    <div class="bg-gradient-to-r from-red-500 to-pink-500 px-4 sm:px-6 md:px-8 py-4 sm:py-6 text-white">
        <h2 class="text-2xl sm:text-3xl font-bold mb-2">Medical Screening</h2>
        <p class="text-sm sm:text-base text-red-50">Your safety is our priority - please answer honestly</p>
    </div>
    
    <!-- Form -->
    <form method="POST" action="{{ route('client.onboarding.save', ['step' => 4]) }}" class="p-4 sm:p-6 md:p-8">
        @csrf
        
        <div class="space-y-6">
            
            <!-- Medical Conditions -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <i class="fas fa-stethoscope text-red-500 mr-2"></i>
                    Do you have any medical conditions? <span class="text-gray-400 font-normal">(Select all that apply)</span>
                </label>
                <div class="grid md:grid-cols-2 gap-3">
                    @php
                        $conditions = [
                            'heart_disease' => 'Heart Disease',
                            'high_blood_pressure' => 'High Blood Pressure',
                            'diabetes' => 'Diabetes',
                            'asthma' => 'Asthma',
                            'arthritis' => 'Arthritis',
                            'back_problems' => 'Back Problems',
                            'joint_issues' => 'Joint Issues',
                            'other' => 'Other Condition',
                        ];
                        $oldConditions = old('medical_conditions', is_array($client->medical_conditions) ? $client->medical_conditions : []);
                    @endphp
                    
                    @foreach($conditions as $value => $label)
                        <label class="relative cursor-pointer">
                            <input type="checkbox" 
                                   name="medical_conditions[]" 
                                   value="{{ $value }}"
                                   {{ in_array($value, $oldConditions) ? 'checked' : '' }}
                                   class="peer sr-only">
                            <div class="border-2 border-gray-200 rounded-lg p-4 transition-all hover:border-red-300 peer-checked:border-red-500 peer-checked:bg-red-50 flex items-center">
                                <div class="w-5 h-5 border-2 border-gray-300 rounded peer-checked:bg-red-500 peer-checked:border-red-500 flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-white text-xs opacity-0 peer-checked:opacity-100"></i>
                                </div>
                                <span class="font-medium text-gray-700">{{ $label }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
                <p class="mt-2 text-xs text-gray-500">Leave unchecked if none apply</p>
            </div>
            
            <!-- Injuries -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <i class="fas fa-band-aid text-red-500 mr-2"></i>
                    Do you have any current or past injuries? <span class="text-gray-400 font-normal">(Select all that apply)</span>
                </label>
                <div class="grid md:grid-cols-2 gap-3">
                    @php
                        $injuries = [
                            'knee_injury' => 'Knee Injury',
                            'shoulder_injury' => 'Shoulder Injury',
                            'back_injury' => 'Back Injury',
                            'ankle_injury' => 'Ankle Injury',
                            'wrist_injury' => 'Wrist Injury',
                            'hip_injury' => 'Hip Injury',
                            'elbow_injury' => 'Elbow Injury',
                            'other_injury' => 'Other Injury',
                        ];
                        $oldInjuries = old('injuries', is_array($client->injuries) ? $client->injuries : []);
                    @endphp
                    
                    @foreach($injuries as $value => $label)
                        <label class="relative cursor-pointer">
                            <input type="checkbox" 
                                   name="injuries[]" 
                                   value="{{ $value }}"
                                   {{ in_array($value, $oldInjuries) ? 'checked' : '' }}
                                   class="peer sr-only">
                            <div class="border-2 border-gray-200 rounded-lg p-4 transition-all hover:border-red-300 peer-checked:border-red-500 peer-checked:bg-red-50 flex items-center">
                                <div class="w-5 h-5 border-2 border-gray-300 rounded peer-checked:bg-red-500 peer-checked:border-red-500 flex items-center justify-center mr-3">
                                    <i class="fas fa-check text-white text-xs opacity-0 peer-checked:opacity-100"></i>
                                </div>
                                <span class="font-medium text-gray-700">{{ $label }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
                <p class="mt-2 text-xs text-gray-500">Leave unchecked if none apply</p>
            </div>
            
            <!-- Current Medications -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-pills text-red-500 mr-2"></i>
                    Current Medications <span class="text-gray-400 font-normal">(Optional)</span>
                </label>
                <textarea name="medications" 
                          rows="3"
                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all outline-none resize-none"
                          placeholder="List any medications you're currently taking...">{{ old('medications', $client->medications) }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Include prescription and over-the-counter medications</p>
            </div>
            
            <!-- Additional Medical Notes -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-file-medical text-red-500 mr-2"></i>
                    Additional Medical Information <span class="text-gray-400 font-normal">(Optional)</span>
                </label>
                <textarea name="medical_notes" 
                          rows="4"
                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all outline-none resize-none"
                          placeholder="Any other medical information we should know about?">{{ old('medical_notes', $client->medical_notes) }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Include allergies, recent surgeries, or other relevant information</p>
            </div>
            
            <!-- Medical Clearance -->
            <div class="bg-yellow-50 border-2 border-yellow-300 rounded-xl p-6">
                <label class="flex items-start cursor-pointer">
                    <input type="checkbox" 
                           name="medical_clearance" 
                           value="1"
                           {{ old('medical_clearance', $client->medical_clearance) ? 'checked' : '' }}
                           class="w-5 h-5 text-emerald-600 border-2 border-gray-300 rounded focus:ring-4 focus:ring-emerald-100 mt-1"
                           required>
                    <div class="ml-4">
                        <p class="font-semibold text-gray-800 mb-2">
                            <i class="fas fa-clipboard-check text-yellow-600 mr-2"></i>
                            Medical Clearance Confirmation
                        </p>
                        <p class="text-sm text-gray-700 leading-relaxed">
                            I confirm that I am physically able to participate in fitness activities. If I have any medical conditions or concerns, I have consulted with my healthcare provider and received clearance to exercise. I understand that I should stop any activity if I experience pain, dizziness, or discomfort.
                        </p>
                    </div>
                </label>
                @error('medical_clearance')
                    <p class="mt-3 text-sm text-red-600 flex items-center ml-9">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                    </p>
                @enderror
            </div>
            
            <!-- Safety Notice -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-500 text-xl mr-3 mt-0.5"></i>
                    <div>
                        <p class="text-sm text-gray-700 font-medium mb-1">Your Privacy Matters</p>
                        <p class="text-xs text-gray-600">Your medical information is confidential and will only be used to ensure your safety and create appropriate fitness programs.</p>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Navigation -->
        <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 mt-8 pt-6 border-t border-gray-200">
            <a href="{{ route('client.onboarding.step', ['step' => 3]) }}" 
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
