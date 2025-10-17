@extends('layouts.trainer')

@section('title', 'Edit Program: ' . $program['name'])

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('trainer.programs.index') }}">Programs</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('trainer.programs.show', $program['id']) }}">{{ $program['name'] }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0">Edit Training Program</h1>
            <p class="text-muted">Modify your training program details and structure</p>
        </div>
    </div>

    <form action="{{ route('trainer.programs.update', $program['id']) }}" method="POST">
        @csrf
        @method('PATCH')
        
        <div class="row">
            <!-- Main Form -->
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Program Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="name" class="form-label">Program Name *</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $program['name'] }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="duration_weeks" class="form-label">Duration (weeks) *</label>
                                <input type="number" class="form-control" id="duration_weeks" name="duration_weeks" value="{{ $program['duration_weeks'] }}" min="1" max="52" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ $program['description'] }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="difficulty_level" class="form-label">Difficulty Level *</label>
                                <select class="form-select" id="difficulty_level" name="difficulty_level" required>
                                    <option value="beginner" {{ $program['difficulty_level'] === 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ $program['difficulty_level'] === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ $program['difficulty_level'] === 'advanced' ? 'selected' : '' }}>Advanced</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="program_type" class="form-label">Program Type *</label>
                                <select class="form-select" id="program_type" name="program_type" required>
                                    <option value="strength_training" {{ $program['program_type'] === 'strength_training' ? 'selected' : '' }}>Strength Training</option>
                                    <option value="cardio" {{ $program['program_type'] === 'cardio' ? 'selected' : '' }}>Cardio</option>
                                    <option value="flexibility" {{ $program['program_type'] === 'flexibility' ? 'selected' : '' }}>Flexibility</option>
                                    <option value="weight_loss" {{ $program['program_type'] === 'weight_loss' ? 'selected' : '' }}>Weight Loss</option>
                                    <option value="muscle_building" {{ $program['program_type'] === 'muscle_building' ? 'selected' : '' }}>Muscle Building</option>
                                    <option value="sports_specific" {{ $program['program_type'] === 'sports_specific' ? 'selected' : '' }}>Sports Specific</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="sessions_per_week" class="form-label">Sessions per Week *</label>
                                <select class="form-select" id="sessions_per_week" name="sessions_per_week" required>
                                    <option value="1" {{ $program['sessions_per_week'] == 1 ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ $program['sessions_per_week'] == 2 ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ $program['sessions_per_week'] == 3 ? 'selected' : '' }}>3</option>
                                    <option value="4" {{ $program['sessions_per_week'] == 4 ? 'selected' : '' }}>4</option>
                                    <option value="5" {{ $program['sessions_per_week'] == 5 ? 'selected' : '' }}>5</option>
                                    <option value="6" {{ $program['sessions_per_week'] == 6 ? 'selected' : '' }}>6</option>
                                    <option value="7" {{ $program['sessions_per_week'] == 7 ? 'selected' : '' }}>7</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="draft" {{ $program['status'] === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ $program['status'] === 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="archived" {{ $program['status'] === 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="equipment_needed" name="equipment_needed" value="1" {{ $program['equipment_needed'] ? 'checked' : '' }}>
                                    <label class="form-check-label" for="equipment_needed">
                                        Equipment Required
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_public" name="is_public" value="1" {{ $program['is_public'] ?? false ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_public">
                                        Make Program Public
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Program Objectives -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Program Objectives</h5>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addObjective()">
                            <i class="fas fa-plus me-1"></i> Add Objective
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="objectives-container">
                            @if(isset($program['objectives']) && count($program['objectives']))
                                @foreach($program['objectives'] as $index => $objective)
                                <div class="objective-item mb-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="objectives[]" value="{{ $objective }}" placeholder="Program objective">
                                        <button type="button" class="btn btn-outline-danger" onclick="removeObjective(this)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="objective-item mb-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="objectives[]" placeholder="Program objective">
                                        <button type="button" class="btn btn-outline-danger" onclick="removeObjective(this)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Workout Schedule -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Workout Schedule</h5>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addWorkoutModal">
                            <i class="fas fa-plus me-1"></i> Add Workout
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="workouts-container">
                            @if(isset($program['workouts']) && count($program['workouts']))
                                @foreach($program['workouts'] as $workout)
                                <div class="workout-item card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6>{{ $workout['title'] }}</h6>
                                                <p class="text-muted mb-2">Week {{ $workout['week'] }}, Day {{ $workout['day'] }} • {{ $workout['duration'] ?? 60 }} minutes</p>
                                                <div class="d-flex gap-2">
                                                    @foreach($workout['focus_areas'] ?? [] as $area)
                                                    <span class="badge bg-light text-dark">{{ $area }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#" onclick="editWorkout({{ json_encode($workout) }})">Edit</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#" onclick="removeWorkout(this)">Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-4 text-muted">
                                    <i class="fas fa-dumbbell fa-2x mb-3"></i>
                                    <p>No workouts added yet. Click "Add Workout" to get started.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Preview -->
                <div class="card shadow-sm mb-4 position-sticky" style="top: 20px;">
                    <div class="card-header">
                        <h5 class="mb-0">Program Preview</h5>
                    </div>
                    <div class="card-body">
                        <div class="program-preview">
                            <h6 id="preview-name">{{ $program['name'] }}</h6>
                            <p id="preview-description" class="text-muted">{{ $program['description'] }}</p>
                            
                            <div class="row text-center mb-3">
                                <div class="col-4">
                                    <div class="preview-stat">
                                        <strong id="preview-duration">{{ $program['duration_weeks'] }}</strong>
                                        <small class="d-block text-muted">Weeks</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="preview-stat">
                                        <strong id="preview-sessions">{{ $program['sessions_per_week'] }}</strong>
                                        <small class="d-block text-muted">Per Week</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="preview-stat">
                                        <span id="preview-difficulty" class="badge bg-secondary">{{ ucfirst($program['difficulty_level']) }}</span>
                                        <small class="d-block text-muted">Level</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <strong class="text-muted">Program Type:</strong>
                                <span id="preview-type" class="ms-2">{{ ucfirst(str_replace('_', ' ', $program['program_type'])) }}</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Equipment:</span>
                                <span id="preview-equipment">{{ $program['equipment_needed'] ? 'Required' : 'Not Required' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card-footer">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Update Program
                            </button>
                            <a href="{{ route('trainer.programs.show', $program['id']) }}" class="btn btn-outline-secondary">
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
// Real-time preview updates
document.getElementById('name').addEventListener('input', function() {
    document.getElementById('preview-name').textContent = this.value || 'Program Name';
});

document.getElementById('description').addEventListener('input', function() {
    document.getElementById('preview-description').textContent = this.value || 'Program Description';
});

document.getElementById('duration_weeks').addEventListener('change', function() {
    document.getElementById('preview-duration').textContent = this.value;
});

document.getElementById('sessions_per_week').addEventListener('change', function() {
    document.getElementById('preview-sessions').textContent = this.value;
});

document.getElementById('difficulty_level').addEventListener('change', function() {
    const badge = document.getElementById('preview-difficulty');
    badge.textContent = this.value.charAt(0).toUpperCase() + this.value.slice(1);
    badge.className = 'badge bg-' + (this.value === 'beginner' ? 'success' : this.value === 'intermediate' ? 'warning' : 'danger');
});

document.getElementById('program_type').addEventListener('change', function() {
    document.getElementById('preview-type').textContent = this.value.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
});

document.getElementById('equipment_needed').addEventListener('change', function() {
    document.getElementById('preview-equipment').textContent = this.checked ? 'Required' : 'Not Required';
});

// Objectives management
function addObjective() {
    const container = document.getElementById('objectives-container');
    const div = document.createElement('div');
    div.className = 'objective-item mb-2';
    div.innerHTML = `
        <div class="input-group">
            <input type="text" class="form-control" name="objectives[]" placeholder="Program objective">
            <button type="button" class="btn btn-outline-danger" onclick="removeObjective(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
}

function removeObjective(button) {
    button.closest('.objective-item').remove();
}

function removeWorkout(button) {
    if (confirm('Are you sure you want to remove this workout?')) {
        button.closest('.workout-item').remove();
    }
}

function editWorkout(workout) {
    // Implementation for editing workouts would go here
    alert('Workout editing functionality to be implemented');
}
</script>
@endpush
@endsection