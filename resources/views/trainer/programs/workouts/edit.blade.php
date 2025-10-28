@extends('layouts.trainer')

@section('title', 'Edit Workout')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('trainer.programs.index') }}">Programs</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('trainer.programs.show', $program->id) }}">{{ $program->name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Workout</li>
                </ol>
            </nav>
            <h1 class="h3 mb-1">Edit Workout: {{ $workout->name }}</h1>
            <p class="text-muted mb-0">Update workout details for {{ $program->name }}</p>
        </div>
    </div>

    <!-- Form -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Workout Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('trainer.programs.workouts.update', [$program->id, $workout->id]) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Workout Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name', $workout->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Workout Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="strength" {{ old('type', $workout->type) == 'strength' ? 'selected' : '' }}>Strength Training</option>
                                    <option value="cardio" {{ old('type', $workout->type) == 'cardio' ? 'selected' : '' }}>Cardio</option>
                                    <option value="flexibility" {{ old('type', $workout->type) == 'flexibility' ? 'selected' : '' }}>Flexibility</option>
                                    <option value="sports" {{ old('type', $workout->type) == 'sports' ? 'selected' : '' }}>Sports Specific</option>
                                    <option value="other" {{ old('type', $workout->type) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="difficulty" class="form-label">Difficulty Level <span class="text-danger">*</span></label>
                                <select class="form-select @error('difficulty') is-invalid @enderror" id="difficulty" name="difficulty" required>
                                    <option value="">Select Difficulty</option>
                                    <option value="beginner" {{ old('difficulty', $workout->difficulty) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ old('difficulty', $workout->difficulty) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ old('difficulty', $workout->difficulty) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                </select>
                                @error('difficulty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="planned" {{ old('status', $workout->status) == 'planned' ? 'selected' : '' }}>Planned</option>
                                    <option value="in_progress" {{ old('status', $workout->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ old('status', $workout->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="skipped" {{ old('status', $workout->status) == 'skipped' ? 'selected' : '' }}>Skipped</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="workout_date" class="form-label">Workout Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('workout_date') is-invalid @enderror"
                                       id="workout_date" name="workout_date" value="{{ old('workout_date', $workout->workout_date->format('Y-m-d')) }}" required>
                                @error('workout_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="duration_minutes" class="form-label">Duration (minutes)</label>
                                <input type="number" class="form-control @error('duration_minutes') is-invalid @enderror"
                                       id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes', $workout->duration_minutes) }}" min="1">
                                @error('duration_minutes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" class="form-control @error('start_time') is-invalid @enderror"
                                       id="start_time" name="start_time" value="{{ old('start_time', $workout->start_time ? $workout->start_time->format('H:i') : '') }}">
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" class="form-control @error('end_time') is-invalid @enderror"
                                       id="end_time" name="end_time" value="{{ old('end_time', $workout->end_time ? $workout->end_time->format('H:i') : '') }}">
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="week_number" class="form-label">Week Number</label>
                                <input type="number" class="form-control @error('week_number') is-invalid @enderror"
                                       id="week_number" name="week_number" value="{{ old('week_number', $workout->week_number ? $workout->week_number : '') }}">
                                @error('week_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="met_value" class="form-label">MET Value</label>
                                <input type="number" class="form-control @error('met_value') is-invalid @enderror"
                                       id="met_value" name="met_value" value="{{ old('met_value', $workout->met_value) }}" min="0" max="25" step="0.1"
                                       placeholder="e.g., 8.0 for running">
                                <small class="form-text text-muted">Metabolic Equivalent of Task (optional - will use default based on workout type)</small>
                                @error('met_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="calories_burned" class="form-label">Estimated Calories Burned</label>
                                <input type="number" class="form-control @error('calories_burned') is-invalid @enderror"
                                       id="calories_burned" name="calories_burned" value="{{ old('calories_burned', $workout->calories_burned) }}" min="0">
                                <small class="form-text text-muted">Leave blank if using MET value for automatic calculation</small>
                                @error('calories_burned')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3">{{ old('description', $workout->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                      id="notes" name="notes" rows="2">{{ old('notes', $workout->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('trainer.programs.show', $program->id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to Program
                            </a>
                            <div>
                                <button type="button" class="btn btn-danger me-2" onclick="deleteWorkout()">
                                    <i class="fas fa-trash me-1"></i> Delete Workout
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Update Workout
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteWorkout() {
    if (confirm('Are you sure you want to delete this workout? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("trainer.programs.workouts.destroy", [$program->id, $workout->id]) }}';

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';

        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
