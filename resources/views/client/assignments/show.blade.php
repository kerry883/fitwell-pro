@php
    $title = $assignment->program->name . ' - My Progress';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                {{ $assignment->program->name }}
            </h2>
            <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    by {{ $assignment->program->trainer->user->full_name ?? 'Trainer' }}
                </div>
                <div class="mt-2 flex items-center text-sm">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @if($assignment->status === 'active') bg-green-100 text-green-800
                        @elseif($assignment->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($assignment->status === 'completed') bg-blue-100 text-blue-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($assignment->status) }}
                    </span>
                </div>
            </div>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0">
            @if($assignment->status === 'active')
                <button type="button"
                        onclick="openProgressModal()"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                    Update Progress
                </button>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Progress Overview -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Progress</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Current Week -->
                    <div class="text-center">
                        <div class="text-3xl font-bold text-emerald-600">{{ $currentWeek }}</div>
                        <div class="text-sm text-gray-500">Current Week</div>
                        <div class="text-xs text-gray-400">of {{ $totalWeeks }}</div>
                    </div>

                    <!-- Progress Percentage -->
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $progressPercentage }}%</div>
                        <div class="text-sm text-gray-500">Complete</div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $progressPercentage }}%"></div>
                        </div>
                    </div>

                    <!-- Sessions Completed -->
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600">{{ $assignment->current_session ?? 0 }}</div>
                        <div class="text-sm text-gray-500">Sessions Done</div>
                        <div class="text-xs text-gray-400">This Week</div>
                    </div>
                </div>

                <!-- Program Timeline -->
                <div class="border-t pt-6">
                    <h4 class="text-sm font-semibold text-gray-900 mb-4">Program Timeline</h4>
                    <div class="space-y-2">
                        @for($week = 1; $week <= $totalWeeks; $week++)
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 w-8 text-xs font-medium text-gray-500">{{ $week }}</div>
                                <div class="flex-1">
                                    <div class="h-2 bg-gray-200 rounded-full">
                                        <div class="h-2 rounded-full transition-all duration-300
                                            @if($week < $currentWeek) bg-emerald-500
                                            @elseif($week === $currentWeek) bg-blue-500
                                            @else bg-gray-300 @endif"
                                             style="width: @if($week < $currentWeek) 100% @elseif($week === $currentWeek) {{ min(100, ($assignment->current_session / $assignment->program->sessions_per_week) * 100) }}% @else 0% @endif">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 text-xs text-gray-500">
                                    @if($week < $currentWeek) Completed
                                    @elseif($week === $currentWeek) In Progress
                                    @else Upcoming @endif
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Upcoming Workouts -->
            @if($assignment->status === 'active' && $upcomingWorkouts->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Upcoming Workouts</h3>
                    <div class="space-y-4">
                        @foreach($upcomingWorkouts as $workout)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $workout->name }}</p>
                                        <p class="text-xs text-gray-500">
                                            Week {{ $workout->week }}, {{ $workout->workout_date ? $workout->workout_date->format('M j') : 'TBD' }}
                                            @if($workout->start_time) • {{ $workout->start_time }} @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ ucfirst($workout->type) }}
                                    </span>
                                    @if($workout->duration_minutes)
                                        <p class="text-xs text-gray-500 mt-1">{{ $workout->duration_minutes }} min</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Program Notes -->
            @if($assignment->notes)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Notes</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $assignment->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Program Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Program Details</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Duration</dt>
                        <dd class="text-sm text-gray-900">{{ $assignment->program->duration_weeks }} weeks</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Sessions per Week</dt>
                        <dd class="text-sm text-gray-900">{{ $assignment->program->sessions_per_week }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Difficulty Level</dt>
                        <dd class="text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($assignment->program->difficulty_level === 'beginner') bg-green-100 text-green-800
                                @elseif($assignment->program->difficulty_level === 'intermediate') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($assignment->program->difficulty_level) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Program Type</dt>
                        <dd class="text-sm text-gray-900">{{ ucfirst($assignment->program->program_type) }}</dd>
                    </div>
                    @if($assignment->program->price)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Price</dt>
                            <dd class="text-sm text-gray-900 font-semibold">${{ number_format($assignment->program->price, 2) }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Trainer Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Trainer</h3>
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-emerald-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-lg">
                                {{ substr($assignment->program->trainer->user->full_name ?? 'T', 0, 1) }}
                            </span>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">{{ $assignment->program->trainer->user->full_name ?? 'Trainer' }}</p>
                        <p class="text-sm text-gray-500">Certified Fitness Trainer</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            @if($assignment->can_withdraw)
                <div class="bg-red-50 rounded-xl border border-red-200 p-6">
                    <h3 class="text-lg font-semibold text-red-900 mb-2">Need to Withdraw?</h3>
                    <p class="text-red-700 text-sm mb-4">If you need to withdraw from this program, you can do so here.</p>
                    <button type="button"
                            onclick="openWithdrawModal()"
                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Withdraw from Program
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Progress Update Modal -->
<div id="progressModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Update Progress</h3>
                <button onclick="closeProgressModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('client.assignments.update-progress', $assignment->id) }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="current_week" class="block text-sm font-medium text-gray-700 mb-2">
                            Current Week
                        </label>
                        <select id="current_week" name="current_week" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500" required>
                            @for($week = 1; $week <= $totalWeeks; $week++)
                                <option value="{{ $week }}" {{ $currentWeek == $week ? 'selected' : '' }}>Week {{ $week }}</option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label for="current_session" class="block text-sm font-medium text-gray-700 mb-2">
                            Sessions Completed This Week
                        </label>
                        <select id="current_session" name="current_session" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500" required>
                            @for($session = 0; $session <= $assignment->program->sessions_per_week; $session++)
                                <option value="{{ $session }}" {{ ($assignment->current_session ?? 0) == $session ? 'selected' : '' }}>{{ $session }}</option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label for="progress_percentage" class="block text-sm font-medium text-gray-700 mb-2">
                            Overall Progress (%)
                        </label>
                        <input type="number" id="progress_percentage" name="progress_percentage" min="0" max="100"
                               value="{{ $progressPercentage }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500" required>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Notes (optional)
                        </label>
                        <textarea id="notes" name="notes" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"
                                  placeholder="Any notes about your progress...">{{ $assignment->notes }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeProgressModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 border border-transparent rounded-md hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        Update Progress
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Withdraw Modal -->
<div id="withdrawModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Withdraw from Program</h3>
                <button onclick="closeWithdrawModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mb-4">
                <p class="text-sm text-gray-600">
                    Are you sure you want to withdraw from <span class="font-medium">{{ $assignment->program->name }}</span>?
                    This action cannot be undone.
                </p>
            </div>

            <form method="POST" action="{{ route('client.assignments.withdraw', $assignment->id) }}">
                @csrf
                @method('DELETE')
                <div class="mb-4">
                    <label for="withdraw_reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Reason for withdrawal (optional)
                    </label>
                    <textarea id="withdraw_reason" name="reason" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"
                              placeholder="Please let us know why you're withdrawing..."></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeWithdrawModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Withdraw
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openProgressModal() {
    document.getElementById('progressModal').classList.remove('hidden');
}

function closeProgressModal() {
    document.getElementById('progressModal').classList.add('hidden');
}

function openWithdrawModal() {
    document.getElementById('withdrawModal').classList.remove('hidden');
}

function closeWithdrawModal() {
    document.getElementById('withdrawModal').classList.add('hidden');
    document.getElementById('withdraw_reason').value = '';
}

// Close modals when clicking outside
document.getElementById('progressModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeProgressModal();
    }
});

document.getElementById('withdrawModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeWithdrawModal();
    }
});
</script>
@endsection
