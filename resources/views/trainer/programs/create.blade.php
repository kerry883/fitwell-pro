@extends('layouts.trainer')

@section('title', 'Create New Program')
@section('page-title', 'Create New Program')
@section('page-subtitle', 'Design a custom training program for your clients')

@section('content')
<div class="row g-4">
    <!-- Back Button -->
    <div class="col-12">
        <a href="{{ route('trainer.programs.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Programs
        </a>
    </div>

    <!-- Program Creation Form -->
    <div class="col-12">
        <form method="POST" action="{{ route('trainer.programs.store') }}">
            @csrf
            <div class="row g-4">
                <!-- Basic Information -->
                <div class="col-md-8">
                    <div class="card trainer-card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Basic Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Program Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" 
                                           placeholder="e.g., Beginner Strength Building">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="program_type" class="form-label">Program Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('program_type') is-invalid @enderror" 
                                            id="program_type" name="program_type">
                                        <option value="">Select program type...</option>
                                        <option value="Strength Training" {{ old('program_type') == 'Strength Training' ? 'selected' : '' }}>Strength Training</option>
                                        <option value="Cardio/HIIT" {{ old('program_type') == 'Cardio/HIIT' ? 'selected' : '' }}>Cardio/HIIT</option>
                                        <option value="Powerlifting" {{ old('program_type') == 'Powerlifting' ? 'selected' : '' }}>Powerlifting</option>
                                        <option value="Weight Loss" {{ old('program_type') == 'Weight Loss' ? 'selected' : '' }}>Weight Loss</option>
                                        <option value="Bodybuilding" {{ old('program_type') == 'Bodybuilding' ? 'selected' : '' }}>Bodybuilding</option>
                                        <option value="Functional Training" {{ old('program_type') == 'Functional Training' ? 'selected' : '' }}>Functional Training</option>
                                        <option value="Athletic Performance" {{ old('program_type') == 'Athletic Performance' ? 'selected' : '' }}>Athletic Performance</option>
                                        <option value="Rehabilitation" {{ old('program_type') == 'Rehabilitation' ? 'selected' : '' }}>Rehabilitation</option>
                                    </select>
                                    @error('program_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="description" class="form-label">Program Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="4" 
                                              placeholder="Describe the program's goals, methodology, and what clients can expect...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Program Structure -->
                    <div class="card trainer-card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-calendar-week me-2"></i>Program Structure</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="duration_weeks" class="form-label">Duration (Weeks) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('duration_weeks') is-invalid @enderror" 
                                           id="duration_weeks" name="duration_weeks" value="{{ old('duration_weeks') }}" 
                                           min="1" max="52" placeholder="8">
                                    @error('duration_weeks')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="sessions_per_week" class="form-label">Sessions per Week <span class="text-danger">*</span></label>
                                    <select class="form-select @error('sessions_per_week') is-invalid @enderror" 
                                            id="sessions_per_week" name="sessions_per_week">
                                        <option value="">Select...</option>
                                        <option value="1" {{ old('sessions_per_week') == '1' ? 'selected' : '' }}>1 session</option>
                                        <option value="2" {{ old('sessions_per_week') == '2' ? 'selected' : '' }}>2 sessions</option>
                                        <option value="3" {{ old('sessions_per_week') == '3' ? 'selected' : '' }}>3 sessions</option>
                                        <option value="4" {{ old('sessions_per_week') == '4' ? 'selected' : '' }}>4 sessions</option>
                                        <option value="5" {{ old('sessions_per_week') == '5' ? 'selected' : '' }}>5 sessions</option>
                                        <option value="6" {{ old('sessions_per_week') == '6' ? 'selected' : '' }}>6 sessions</option>
                                        <option value="7" {{ old('sessions_per_week') == '7' ? 'selected' : '' }}>7 sessions</option>
                                    </select>
                                    @error('sessions_per_week')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="difficulty_level" class="form-label">Difficulty Level <span class="text-danger">*</span></label>
                                    <select class="form-select @error('difficulty_level') is-invalid @enderror" 
                                            id="difficulty_level" name="difficulty_level">
                                        <option value="">Select level...</option>
                                        <option value="beginner" {{ old('difficulty_level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                        <option value="intermediate" {{ old('difficulty_level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                        <option value="advanced" {{ old('difficulty_level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                    </select>
                                    @error('difficulty_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Program Goals & Requirements -->
                    <div class="card trainer-card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-bullseye me-2"></i>Goals & Requirements</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Primary Goals</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="goal_weight_loss" name="goals[]" value="weight_loss">
                                        <label class="form-check-label" for="goal_weight_loss">Weight Loss</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="goal_muscle_gain" name="goals[]" value="muscle_gain">
                                        <label class="form-check-label" for="goal_muscle_gain">Muscle Gain</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="goal_strength" name="goals[]" value="strength">
                                        <label class="form-check-label" for="goal_strength">Strength Building</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="goal_endurance" name="goals[]" value="endurance">
                                        <label class="form-check-label" for="goal_endurance">Endurance</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Equipment Required</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="eq_none" name="equipment[]" value="none">
                                        <label class="form-check-label" for="eq_none">Bodyweight Only</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="eq_dumbbells" name="equipment[]" value="dumbbells">
                                        <label class="form-check-label" for="eq_dumbbells">Dumbbells</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="eq_barbell" name="equipment[]" value="barbell">
                                        <label class="form-check-label" for="eq_barbell">Barbell</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="eq_machines" name="equipment[]" value="machines">
                                        <label class="form-check-label" for="eq_machines">Machines</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-md-4">
                    <!-- Program Preview -->
                    <div class="card trainer-card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-eye me-2"></i>Program Preview</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" 
                                     style="width: 60px; height: 60px;">
                                    <i class="bi bi-journal-text text-muted" style="font-size: 1.5rem;"></i>
                                </div>
                                <h6 id="preview-name">Program Name</h6>
                                <small class="text-muted" id="preview-type">Program Type</small>
                            </div>
                            
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="text-center p-2 bg-light rounded">
                                        <div class="fw-bold text-primary" id="preview-duration">-</div>
                                        <small class="text-muted">Weeks</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center p-2 bg-light rounded">
                                        <div class="fw-bold text-success" id="preview-sessions">-</div>
                                        <small class="text-muted">Sessions/Week</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <span class="badge bg-light text-dark" id="preview-difficulty">Difficulty</span>
                            </div>

                            <p class="text-muted small" id="preview-description">
                                Program description will appear here...
                            </p>
                        </div>
                    </div>

                    <!-- Program Tips -->
                    <div class="card trainer-card mt-4">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="bi bi-lightbulb me-2"></i>Program Creation Tips</h6>
                        </div>
                        <div class="card-body">
                            <div class="small">
                                <div class="mb-2">
                                    <i class="bi bi-check-circle text-success me-1"></i>
                                    <strong>Clear objectives:</strong> Define specific, measurable goals
                                </div>
                                <div class="mb-2">
                                    <i class="bi bi-check-circle text-success me-1"></i>
                                    <strong>Progressive structure:</strong> Gradually increase intensity
                                </div>
                                <div class="mb-2">
                                    <i class="bi bi-check-circle text-success me-1"></i>
                                    <strong>Realistic duration:</strong> Consider client commitment level
                                </div>
                                <div class="mb-2">
                                    <i class="bi bi-check-circle text-success me-1"></i>
                                    <strong>Equipment access:</strong> Match client's available resources
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card trainer-card mt-4">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn trainer-btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>Create Program
                                </button>
                                <button type="button" class="btn btn-outline-secondary">
                                    <i class="bi bi-eye me-2"></i>Save as Draft
                                </button>
                                <a href="{{ route('trainer.programs.index') }}" class="btn btn-outline-danger">
                                    <i class="bi bi-x-circle me-2"></i>Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Live preview updates
    document.getElementById('name').addEventListener('input', function() {
        document.getElementById('preview-name').textContent = this.value || 'Program Name';
    });

    document.getElementById('program_type').addEventListener('change', function() {
        document.getElementById('preview-type').textContent = this.value || 'Program Type';
    });

    document.getElementById('duration_weeks').addEventListener('input', function() {
        document.getElementById('preview-duration').textContent = this.value || '-';
    });

    document.getElementById('sessions_per_week').addEventListener('change', function() {
        document.getElementById('preview-sessions').textContent = this.value || '-';
    });

    document.getElementById('difficulty_level').addEventListener('change', function() {
        const difficulty = this.value;
        const badge = document.getElementById('preview-difficulty');
        badge.textContent = difficulty ? difficulty.charAt(0).toUpperCase() + difficulty.slice(1) : 'Difficulty';
        
        // Update badge color based on difficulty
        badge.className = 'badge';
        if (difficulty === 'beginner') {
            badge.className += ' bg-success text-white';
        } else if (difficulty === 'intermediate') {
            badge.className += ' bg-warning text-white';
        } else if (difficulty === 'advanced') {
            badge.className += ' bg-danger text-white';
        } else {
            badge.className += ' bg-light text-dark';
        }
    });

    document.getElementById('description').addEventListener('input', function() {
        const preview = document.getElementById('preview-description');
        const text = this.value || 'Program description will appear here...';
        preview.textContent = text.length > 100 ? text.substring(0, 100) + '...' : text;
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const requiredFields = ['name', 'program_type', 'description', 'duration_weeks', 'sessions_per_week', 'difficulty_level'];
        let isValid = true;

        requiredFields.forEach(field => {
            const input = document.getElementById(field);
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
        }
    });
</script>
@endpush