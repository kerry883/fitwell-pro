<!-- Profile Header -->
<div class="bg-gradient-to-r from-green-500 to-cyan-500 rounded-xl p-8 mb-8 text-white shadow-lg">
    <div class="flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-6">
        <!-- Profile Photo -->
        <div class="relative">
            <div class="w-32 h-32 rounded-full bg-white/20 backdrop-blur-sm border-4 border-white/30 overflow-hidden">
                @if(Auth::user()->profile_picture)
                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Photo" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-4xl font-bold text-white/80">
                        {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <button onclick="document.getElementById('photo-upload').click()"
                    class="absolute bottom-0 right-0 bg-white text-blue-600 p-2 rounded-full shadow-lg hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </button>
            <form id="photo-form" action="{{ route('profile.upload-photo') }}" method="POST" enctype="multipart/form-data" class="hidden">
                @csrf
                <input type="file" id="photo-upload" name="profile_photo" accept="image/*" onchange="document.getElementById('photo-form').submit()">
            </form>
        </div>

        <!-- Profile Info -->
        <div class="flex-1 text-center md:text-left">
            <h1 class="text-3xl font-bold mb-2">{{ Auth::user()->full_name }}</h1>
            <p class="text-blue-100 mb-4">{{ Auth::user()->email }}</p>
            <div class="flex flex-wrap justify-center md:justify-start gap-4 text-sm">
                @if(Auth::user()->age)
                    <span class="bg-white/20 px-3 py-1 rounded-full">{{ Auth::user()->age }} years old</span>
                @endif
                @if(Auth::user()->fitness_level)
                    <span class="bg-white/20 px-3 py-1 rounded-full capitalize">{{ Auth::user()->fitness_level }}</span>
                @endif
                @if(Auth::user()->bmi)
                    <span class="bg-white/20 px-3 py-1 rounded-full">BMI: {{ Auth::user()->bmi }}</span>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Profile Sections -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Profile Form -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Basic Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Basic Information</h2>
                <button type="button" onclick="toggleEdit('basic-info')"
                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Edit
                </button>
            </div>

            <form id="basic-info-form" action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name', Auth::user()->first_name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name', Auth::user()->last_name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                        <select name="gender" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', Auth::user()->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', Auth::user()->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', Auth::user()->gender) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Age</label>
                        <input type="number" name="age" value="{{ old('age', Auth::user()->age) }}" min="13" max="120"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Height (cm)</label>
                        <input type="number" name="height" value="{{ old('height', Auth::user()->height) }}" step="0.1"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Weight (kg)</label>
                        <input type="number" name="weight" value="{{ old('weight', Auth::user()->weight) }}" step="0.1"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fitness Level</label>
                        <select name="fitness_level" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Level</option>
                            <option value="beginner" {{ old('fitness_level', Auth::user()->fitness_level) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="intermediate" {{ old('fitness_level', Auth::user()->fitness_level) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="advanced" {{ old('fitness_level', Auth::user()->fitness_level) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Activity Level</label>
                        <select name="activity_level" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Activity Level</option>
                            <option value="sedentary" {{ old('activity_level', Auth::user()->activity_level) == 'sedentary' ? 'selected' : '' }}>Sedentary</option>
                            <option value="lightly_active" {{ old('activity_level', Auth::user()->activity_level) == 'lightly_active' ? 'selected' : '' }}>Lightly Active</option>
                            <option value="moderately_active" {{ old('activity_level', Auth::user()->activity_level) == 'moderately_active' ? 'selected' : '' }}>Moderately Active</option>
                            <option value="very_active" {{ old('activity_level', Auth::user()->activity_level) == 'very_active' ? 'selected' : '' }}>Very Active</option>
                            <option value="extremely_active" {{ old('activity_level', Auth::user()->activity_level) == 'extremely_active' ? 'selected' : '' }}>Extremely Active</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="cancelEdit('basic-info')"
                            class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Fitness Preferences -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Fitness Preferences</h2>
                <button type="button" onclick="toggleEdit('fitness-prefs')"
                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Edit
                </button>
            </div>

            <form id="fitness-prefs-form" action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Experience Level</label>
                        <select name="experience_level" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Level</option>
                            <option value="beginner" {{ old('experience_level', $profile->experience_level) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="intermediate" {{ old('experience_level', $profile->experience_level) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="advanced" {{ old('experience_level', $profile->experience_level) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Available Days per Week</label>
                        <input type="number" name="available_days_per_week" value="{{ old('available_days_per_week', $profile->available_days_per_week) }}" min="1" max="7"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Workout Duration (minutes)</label>
                        <input type="number" name="workout_duration_preference" value="{{ old('workout_duration_preference', $profile->workout_duration_preference) }}" min="15" max="180"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Workout Time</label>
                        <input type="time" name="preferred_workout_time" value="{{ old('preferred_workout_time', $profile->preferred_workout_time ? $profile->preferred_workout_time->format('H:i') : '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Preferred Workout Types</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @php
                            $workoutTypes = ['Strength Training', 'Cardio', 'Yoga', 'Pilates', 'HIIT', 'CrossFit', 'Running', 'Swimming', 'Cycling'];
                            $currentTypes = $profile->preferred_workout_types ?? [];
                        @endphp
                        @foreach($workoutTypes as $type)
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="preferred_workout_types[]" value="{{ $type }}"
                                       {{ in_array($type, $currentTypes) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">{{ $type }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="cancelEdit('fitness-prefs')"
                            class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Medical Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Medical Information</h2>
                <button type="button" onclick="toggleEdit('medical-info')"
                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Edit
                </button>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="text-sm text-yellow-800">
                        <p class="font-medium">Important: This information is shared with your trainer for safety purposes.</p>
                    </div>
                </div>
            </div>

            <form id="medical-info-form" action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Medical Conditions</label>
                        <textarea name="medical_conditions[]" rows="3"
                                  placeholder="List any medical conditions (one per line)"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('medical_conditions', $profile->medical_conditions ? implode("\n", $profile->medical_conditions) : '') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Injuries</label>
                        <textarea name="injuries[]" rows="3"
                                  placeholder="List any injuries (one per line)"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('injuries', $profile->injuries ? implode("\n", $profile->injuries) : '') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="cancelEdit('medical-info')"
                            class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Fitness Goals -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Fitness Goals</h3>
                <button type="button" onclick="toggleEdit('goals')"
                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Edit
                </button>
            </div>

            <form id="goals-form" action="{{ route('profile.update-goals') }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 gap-3">
                    @php
                        $availableGoals = ['Weight Loss', 'Muscle Gain', 'Strength Training', 'Endurance', 'Flexibility', 'General Fitness', 'Sports Performance', 'Rehabilitation'];
                        $currentGoals = old('goals', $profile->goals ?? []);
                    @endphp

                    @foreach($availableGoals as $goal)
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="goals[]" value="{{ $goal }}"
                                   {{ in_array($goal, $currentGoals) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-3 text-sm text-gray-700">{{ $goal }}</span>
                        </label>
                    @endforeach
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                    Update Goals
                </button>
            </form>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Stats</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">BMI</span>
                    <span class="font-semibold">{{ Auth::user()->bmi ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Active Programs</span>
                    <span class="font-semibold">{{ $profile->assignments()->active()->count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Completed Workouts</span>
                    <span class="font-semibold">{{ Auth::user()->workouts()->where('status', 'completed')->count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleEdit(section) {
    const form = document.getElementById(section + '-form');
    const display = document.getElementById(section + '-display');

    if (form.style.display === 'none' || form.style.display === '') {
        form.style.display = 'block';
        if (display) display.style.display = 'none';
    } else {
        form.style.display = 'none';
        if (display) display.style.display = 'block';
    }
}

function cancelEdit(section) {
    const form = document.getElementById(section + '-form');
    const display = document.getElementById(section + '-display');

    form.style.display = 'none';
    if (display) display.style.display = 'block';
}

// Initialize forms as hidden
document.addEventListener('DOMContentLoaded', function() {
    const forms = ['basic-info-form', 'fitness-prefs-form', 'medical-info-form', 'goals-form'];
    forms.forEach(formId => {
        const form = document.getElementById(formId);
        if (form) {
            // Show form if there are validation errors
            const hasErrors = @json(session('errors') && session('errors')->hasAny(array_keys(request()->all())));
            if (hasErrors) {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
    });
});
</script>
