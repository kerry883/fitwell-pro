@extends('layouts.trainer')

@section('title', 'Edit Session')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('trainer.schedule.index') }}">Schedule</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('trainer.schedule.show', $session['id']) }}">Session Details</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0">Edit Training Session</h1>
            <p class="text-muted">Modify session details and workout plan</p>
        </div>
    </div>

    <form action="{{ route('trainer.schedule.update', $session['id']) }}" method="POST">
        @csrf
        @method('PATCH')
        
        <div class="row">
            <!-- Main Form -->
            <div class="col-lg-8">
                <!-- Session Details -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Session Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="title" class="form-label">Session Title *</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $session['title'] }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="session_type" class="form-label">Session Type *</label>
                                <select class="form-select" id="session_type" name="session_type" required>
                                    <option value="personal_training" {{ $session['session_type'] === 'personal_training' ? 'selected' : '' }}>Personal Training</option>
                                    <option value="group_training" {{ $session['session_type'] === 'group_training' ? 'selected' : '' }}>Group Training</option>
                                    <option value="consultation" {{ $session['session_type'] === 'consultation' ? 'selected' : '' }}>Consultation</option>
                                    <option value="assessment" {{ $session['session_type'] === 'assessment' ? 'selected' : '' }}>Fitness Assessment</option>
                                    <option value="follow_up" {{ $session['session_type'] === 'follow_up' ? 'selected' : '' }}>Follow-up</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="client_id" class="form-label">Client *</label>
                                <select class="form-select" id="client_id" name="client_id" required>
                                    @foreach($clients ?? [] as $client)
                                    <option value="{{ $client['id'] }}" {{ $session['client_id'] == $client['id'] ? 'selected' : '' }}>
                                        {{ $client['name'] }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="location" class="form-label">Location *</label>
                                <select class="form-select" id="location" name="location" required>
                                    <option value="gym" {{ $session['location'] === 'gym' ? 'selected' : '' }}>Gym</option>
                                    <option value="client_home" {{ $session['location'] === 'client_home' ? 'selected' : '' }}>Client's Home</option>
                                    <option value="outdoor" {{ $session['location'] === 'outdoor' ? 'selected' : '' }}>Outdoor</option>
                                    <option value="online" {{ $session['location'] === 'online' ? 'selected' : '' }}>Online/Virtual</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="date" class="form-label">Date *</label>
                                <input type="date" class="form-control" id="date" name="date" value="{{ $session['date'] }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="start_time" class="form-label">Start Time *</label>
                                <input type="time" class="form-control" id="start_time" name="start_time" value="{{ $session['start_time'] }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="duration" class="form-label">Duration (minutes) *</label>
                                <select class="form-select" id="duration" name="duration" required>
                                    <option value="30" {{ $session['duration'] == 30 ? 'selected' : '' }}>30 minutes</option>
                                    <option value="45" {{ $session['duration'] == 45 ? 'selected' : '' }}>45 minutes</option>
                                    <option value="60" {{ $session['duration'] == 60 ? 'selected' : '' }}>60 minutes</option>
                                    <option value="90" {{ $session['duration'] == 90 ? 'selected' : '' }}>90 minutes</option>
                                    <option value="120" {{ $session['duration'] == 120 ? 'selected' : '' }}>120 minutes</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="rate" class="form-label">Session Rate ($)</label>
                                <input type="number" class="form-control" id="rate" name="rate" value="{{ $session['rate'] }}" step="0.01" min="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="scheduled" {{ $session['status'] === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    <option value="in_progress" {{ $session['status'] === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ $session['status'] === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $session['status'] === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="no_show" {{ $session['status'] === 'no_show' ? 'selected' : '' }}>No Show</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Session Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ $session['description'] }}</textarea>
                        </div>

                        <!-- Recurring Options -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="recurring" name="recurring" value="1" {{ $session['recurring'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="recurring">
                                    Recurring Session
                                </label>
                            </div>
                        </div>

                        <div id="recurring-options" class="row" style="display: {{ $session['recurring'] ? 'block' : 'none' }};">
                            <div class="col-md-6 mb-3">
                                <label for="recurring_type" class="form-label">Recurring Type</label>
                                <select class="form-select" id="recurring_type" name="recurring_type">
                                    <option value="weekly" {{ $session['recurring_type'] === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="bi_weekly" {{ $session['recurring_type'] === 'bi_weekly' ? 'selected' : '' }}>Bi-weekly</option>
                                    <option value="monthly" {{ $session['recurring_type'] === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="recurring_end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="recurring_end_date" name="recurring_end_date" value="{{ $session['recurring_end_date'] ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Session Goals -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Session Goals</h5>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addGoal()">
                            <i class="fas fa-plus me-1"></i> Add Goal
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="goals-container">
                            @if(isset($session['goals']) && count($session['goals']))
                                @foreach($session['goals'] as $goal)
                                <div class="goal-item mb-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="goals[]" value="{{ $goal }}" placeholder="Session goal">
                                        <button type="button" class="btn btn-outline-danger" onclick="removeGoal(this)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="goal-item mb-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="goals[]" placeholder="Session goal">
                                        <button type="button" class="btn btn-outline-danger" onclick="removeGoal(this)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Workout Plan -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Workout Plan</h5>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addExercise()">
                            <i class="fas fa-plus me-1"></i> Add Exercise
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="exercises-container">
                            @if(isset($session['workout']['exercises']) && count($session['workout']['exercises']))
                                @foreach($session['workout']['exercises'] as $index => $exercise)
                                <div class="exercise-item card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="mb-0">Exercise {{ $index + 1 }}</h6>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeExercise(this)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <input type="text" class="form-control form-control-sm" name="exercises[{{ $index }}][name]" value="{{ $exercise['name'] }}" placeholder="Exercise name">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <input type="text" class="form-control form-control-sm" name="exercises[{{ $index }}][muscle_group]" value="{{ $exercise['muscle_group'] ?? '' }}" placeholder="Muscle group">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2 mb-2">
                                                <input type="number" class="form-control form-control-sm" name="exercises[{{ $index }}][sets]" value="{{ $exercise['sets'] }}" placeholder="Sets">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <input type="text" class="form-control form-control-sm" name="exercises[{{ $index }}][reps]" value="{{ $exercise['reps'] }}" placeholder="Reps">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <input type="text" class="form-control form-control-sm" name="exercises[{{ $index }}][weight]" value="{{ $exercise['weight'] ?? '' }}" placeholder="Weight">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <input type="text" class="form-control form-control-sm" name="exercises[{{ $index }}][rest]" value="{{ $exercise['rest'] }}" placeholder="Rest time">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="text" class="form-control form-control-sm" name="exercises[{{ $index }}][notes]" value="{{ $exercise['notes'] ?? '' }}" placeholder="Exercise notes">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>

                        @if(!isset($session['workout']['exercises']) || count($session['workout']['exercises']) === 0)
                        <div class="text-center py-3 text-muted">
                            <i class="fas fa-dumbbell fa-2x mb-2"></i>
                            <p>No exercises added yet. Click "Add Exercise" to build the workout.</p>
                        </div>
                        @endif

                        <div class="mt-3">
                            <label for="workout_notes" class="form-label">Workout Notes</label>
                            <textarea class="form-control" id="workout_notes" name="workout_notes" rows="2">{{ $session['workout']['notes'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Session Summary -->
                <div class="card shadow-sm mb-4 position-sticky" style="top: 20px;">
                    <div class="card-header">
                        <h5 class="mb-0">Session Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="session-summary">
                            <h6 id="summary-title">{{ $session['title'] }}</h6>
                            <p id="summary-client" class="text-muted">{{ $session['client_name'] ?? 'Select client' }}</p>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Date:</span>
                                    <span id="summary-date">{{ $session['date'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Time:</span>
                                    <span id="summary-time">{{ $session['start_time'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Duration:</span>
                                    <span id="summary-duration">{{ $session['duration'] }} min</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Location:</span>
                                    <span id="summary-location">{{ ucfirst($session['location']) }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Rate:</span>
                                    <strong id="summary-rate">${{ number_format($session['rate'], 2) }}</strong>
                                </div>
                            </div>

                            <div class="mb-3">
                                <span class="text-muted">Status:</span>
                                <span id="summary-status" class="badge bg-{{ $session['status_color'] }} ms-2">{{ ucfirst($session['status']) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card-footer">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Update Session
                            </button>
                            <a href="{{ route('trainer.schedule.show', $session['id']) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i> Cancel Changes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Recurring session toggle
document.getElementById('recurring').addEventListener('change', function() {
    const options = document.getElementById('recurring-options');
    options.style.display = this.checked ? 'block' : 'none';
});

// Real-time summary updates
document.getElementById('title').addEventListener('input', function() {
    document.getElementById('summary-title').textContent = this.value || 'Session Title';
});

document.getElementById('date').addEventListener('change', function() {
    document.getElementById('summary-date').textContent = this.value;
});

document.getElementById('start_time').addEventListener('change', function() {
    document.getElementById('summary-time').textContent = this.value;
});

document.getElementById('duration').addEventListener('change', function() {
    document.getElementById('summary-duration').textContent = this.value + ' min';
});

document.getElementById('location').addEventListener('change', function() {
    document.getElementById('summary-location').textContent = this.value.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
});

document.getElementById('rate').addEventListener('input', function() {
    document.getElementById('summary-rate').textContent = '$' + parseFloat(this.value || 0).toFixed(2);
});

// Goals management
let goalCount = {{ count($session['goals'] ?? []) }};

function addGoal() {
    const container = document.getElementById('goals-container');
    const div = document.createElement('div');
    div.className = 'goal-item mb-2';
    div.innerHTML = `
        <div class="input-group">
            <input type="text" class="form-control" name="goals[]" placeholder="Session goal">
            <button type="button" class="btn btn-outline-danger" onclick="removeGoal(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
}

function removeGoal(button) {
    button.closest('.goal-item').remove();
}

// Exercise management
let exerciseCount = {{ count($session['workout']['exercises'] ?? []) }};

function addExercise() {
    const container = document.getElementById('exercises-container');
    const div = document.createElement('div');
    div.className = 'exercise-item card mb-3';
    div.innerHTML = `
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <h6 class="mb-0">Exercise ${exerciseCount + 1}</h6>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeExercise(this)">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <input type="text" class="form-control form-control-sm" name="exercises[${exerciseCount}][name]" placeholder="Exercise name">
                </div>
                <div class="col-md-6 mb-2">
                    <input type="text" class="form-control form-control-sm" name="exercises[${exerciseCount}][muscle_group]" placeholder="Muscle group">
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 mb-2">
                    <input type="number" class="form-control form-control-sm" name="exercises[${exerciseCount}][sets]" placeholder="Sets">
                </div>
                <div class="col-md-3 mb-2">
                    <input type="text" class="form-control form-control-sm" name="exercises[${exerciseCount}][reps]" placeholder="Reps">
                </div>
                <div class="col-md-3 mb-2">
                    <input type="text" class="form-control form-control-sm" name="exercises[${exerciseCount}][weight]" placeholder="Weight">
                </div>
                <div class="col-md-4 mb-2">
                    <input type="text" class="form-control form-control-sm" name="exercises[${exerciseCount}][rest]" placeholder="Rest time">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <input type="text" class="form-control form-control-sm" name="exercises[${exerciseCount}][notes]" placeholder="Exercise notes">
                </div>
            </div>
        </div>
    `;
    container.appendChild(div);
    exerciseCount++;
}

function removeExercise(button) {
    if (confirm('Remove this exercise?')) {
        button.closest('.exercise-item').remove();
    }
}
</script>
@endpush
@endsection